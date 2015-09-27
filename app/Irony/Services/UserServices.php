<?php namespace Irony\Services;

use Event;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;

use Irony\Entities\User;

use Irony\Services\Exceptions\ImageValidationException;
use Irony\Services\Exceptions\UserNotFoundException;
use Irony\Services\Exceptions\UserServiceException;

/**
 * Class UserServices
 * @package Irony\Services
 * provides services in a single location and separates logic from controller layer
 */
class UserServices
{
    /**
     * Create a user
     *
     * @param array $input
     *  Required: username, firstname, lastname, email, password, password_confirmation
     *  Optional: avatar
     * @param bool $sendConfirm
     * @return User
     * @throws Exceptions\ImageValidationException
     * @throws Exceptions\UserServiceException
     */
    public  function create(array $input, $sendConfirm = true)
	{
        /** Grab form data */
		$user = new User;
		$user->username = $input['username'];
	    $user->firstname = $input['firstname'];
	    $user->lastname = $input['lastname'];
	    $user->email = $input['email'];
	    $user->password = $input['password'];
	    $user->password_confirmation = $input['password_confirmation'];

        /** Send Confirmation email and set active state of user to false */
        if ($sendConfirm)
        {
            /* Make extra sure no users get the same activation token */
            do {
                $user->token = STR::random(64);
            }
            while ( User::where('token', $user->token)->first() );
            /** Set the user active status to false, preventing login*/
            $user->active = false;
        }
        else
            $user->active = true; // Set the user Active


        /** Validate avatar, return merged avatar User model errors if there is an issue */
        if (!   empty($input['avatar']) )
        {
            $val =  Validator::make($input,User::$avatarRules);
            if ($val->fails())
            {
                $user->validate();
                throw new ImageValidationException(array_merge($val->messages()->all(),$user->errors()->all()));
            }
        }
        if (!$user->save())
            throw new UserServiceException($user);

        /** Set the users avatar **/
        if (!   empty($input['avatar']) )
            $user->avatar = $input['avatar'];

        /** Fire the users.create event to send out the email */
        if ($sendConfirm) Event::fire('users.create', $user);

        /** Returns true when everything is a-ok */
	    return $user;
	}


    /**
     * Update a User
     *
     * @param $id
     * @param $input array
     *  Optional: firstname, lastname, email, avatar
     * @return bool
     * @throws Exceptions\ImageValidationException
     * @throws Exceptions\UserNotFoundException
     * @throws Exceptions\UserServiceException
     */
    public function update($id, array $input)
	{
        //Use our own exception and not find or fail
        $user = User::whereId($id)->first();
		if (! empty($user)    )
		{
		    $user->firstname = $input['firstname'];
		    $user->lastname = $input['lastname'];
		    $user->email = $input['email'];

            /** Avatar Logic **/
            if (!   empty($input['avatar']) )
            {
                $val =  Validator::make($input,User::$avatarRules);
                if ($val->fails())
                {
                    $user->validate();
                    throw new ImageValidationException(array_merge($val->messages()->all(),$user->errors()->all()));
                }
                $user->avatar = $input['avatar'];
            }

            if (!$user->updateUniques(User::$nopassRules))
                throw new UserServiceException( $user );

			return true;
	    }
	    else
	    	throw new UserNotFoundException();
	}

    /**
     * Confirm a user via a email token and sets them to active, removing their token from the database
     * @param $token string Activation Token
     * @return bool
     * @throws Exceptions\UserNotFoundException
     * @throws Exceptions\UserServiceException
     */
    public function confirm($token)
    {
        $user = User::whereToken($token)->first();
        if (!empty($token) )
        {
            $user->active = true;
            $user->token = null;

            if (!$user->updateUniques(User::$nopassRules))
                throw new UserServiceException($user);
            return true;
        }
        else
            throw new UserNotFoundException();
    }

    /**
     * Reset the users Password.
     * Used to reset the users password
     * @param array $credentials email, password, password_confirmation
     * @return mixed Returns a Laravel 4.1 Password constant
     */
    public function reset(
        array $credentials
    )
    {
        $confirmation = $credentials['password_confirmation'];
        return Password::reset($credentials, function($user, $password) use ($confirmation)
        {
            $user->password_confirmation = $confirmation;
            $user->password = $password;

            if (!$user->updateUniques())
                throw new UserServiceException($user);
        });
    }

    public function suspend($id)
    {
        $user = User::find($id);
        if (!empty($user))
        {

            $user->remember_token = null; //Null out Remember token
            $user->active = false; // Deactivate the account

            $user->updateUniques(User::$nopassRules); // Save the user

            $user->delete(); // Soft Delete the user
        }
        else
            throw new UserNotFoundException;
    }

    public function restore($id)
    {
        $user = User::onlyTrashed()->find($id);
        if (!empty($user))
        {
            // Ardent Hack
            $rules = User::$rules;
            User::$rules=[];

            $user->active = true;
            $user->restore($id);

            // Ardent Hack
            User::$rules = $rules;

        }
        else
            throw new UserNotFoundException;
    }

    /**
     * @param $id
     * @throws Exceptions\UserNotFoundException
     */
    public function switchActive($id)
    {
        $user = User::find($id);
        if (!empty($user))
        {
            $state = $user->active;
            switch ($state)
            {
                case 0:
                    $user->active = 1;
                    break;
                case 1:
                    $user->active = 0;
                    break;
                default:
                    throw new UserNotFoundException('Invalid Active state');
            }
            $user->updateUniques(User::$nopassRules);
        }
        else
            throw new UserNotFoundException;
    }

    /**
     * Delete the users avatar ( First image in $user->images )
     * @param $id
     * @return bool
     * @throws Exceptions\UserNotFoundException
     */
    public function deleteAvatar($id)
    {
        $user = User::find($id);
        if (!empty($user))
        {
            $avatar = $user->images->first();
            if (!empty($avatar))
            {
                $avatar->image->clear();
                return $avatar->delete();
            }
            return false;
        }
        else
            Throw new UserNotFoundException;
    }
    /**
     * Forcibly delete a user
     * @param $id
     * @throws Exceptions\UserNotFoundException
     */
    public function delete($id)
    {
        $user = User::onlyTrashed()->find($id);
        if (!empty($user))
        {
            $user->forceDelete(); // Soft Delete the user
        }
        else
            throw new UserNotFoundException;

    }

}