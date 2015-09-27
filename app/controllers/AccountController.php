<?php
use Irony\Services\UserServices;

use Irony\Services\Exceptions\UserServiceException;
use Irony\Services\Exceptions\ImageValidationException;
/**
 * Class AccountController
 * Modify User accounts.
 * todo: Will need to extrapolate to different classes
 */
class AccountController extends \BaseController
{
    protected   $UserServices;

    /**
     * @param UserServices $UserServices
     */
    public function __construct(UserServices $UserServices)
    {
        $this->UserServices = $UserServices;
    }

    /**
     * Return the users profile
     * @return mixed
     */
    public function getProfile()
    {
        $user = Auth::user()->load([
            'items' => function($query)
                {
                    $query->with('images')->orderBy('created_at','desc');
                }
        ,'roles','images']);

        if (! $user->roles->isEmpty() )
           $user->roles->load('perms');

        return View::make('account.profile')
            ->withUser($user)
            ->withIsOwner(true);
    //Users.show
    }


    /**
     * Display the user signup
     * @return \Illuminate\View\View
     */
    public function getSignup()
    {
        Former::withRules(Irony\Entities\User::$rules);
        return View::make('account.signup');
        //Users.create
    }

    /**
     * Handle the user signup data
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postSignup()
    {
        try {
            $this->UserServices->create(
                    Input::all(),
                    true //todo:    Change activation email
                );
            return Redirect::home()->withMessage('Please check your email to confirm activation');
        }
        catch( UserServiceException $e) {
            return Redirect::route('account.signup')->withErrors($e->errors() )->withInput();
        }
        catch (ImageValidationException $e)
        {
            Former::withErrors();
            return Redirect::back()->withErrors($e->errors())->withInput();
        }

    //Users.store
    }

    /** Display the user settings
     * @return  \Illuminate\View\View
     */
    public function getSettings()
    {
        Former::withRules(Irony\Entities\User::$nopassRules);
        return View::make('account.settings')->withUser(Auth::user()->load('images'));
    }

    /**
     * Processes the user settings changes
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postSettings()
    {
        try {
            $this->UserServices->update(
            Auth::user()->id,
            Input::all()
        );
        }
        catch (UserServiceException $e)
        {
            return Redirect::back()->withInput()->withErrors($e->errors() );
        }
        catch (ImageValidationException $e)
        {
            return Redirect::back()->withErrors($e->errors())->withInput();
        }
        catch(UserNotFoundException $e)
        {
           return Redirect::home()->withError('This account no longer exists');
        }

        //Redirect them to login page
        return Redirect::route('account.profile')->withMessage('Your information has been updated')->withInput();
    }
    public function patchDeleteAvatar()
    {
        try {
            if($this->UserServices->deleteAvatar(Auth::user()->id))
                return Redirect::back()->withMessage('Avatar Deleted');
            return Redirect::back()->withError('Something went wrong deleting your Avatar');
        }
        catch (UserNotFoundException $e)
        {
            return Redirect::back()->withError('This account no longer exists');
        }
    }



}
