<?php
// In development, not exactly sure how to work out user access issues

use Irony\Entities\User;
use Irony\Services\UserServices;

use Irony\Services\Exceptions\UserServiceException;
use Irony\Services\Exceptions\UserNotFoundException;

/**
 * Class UsersController
 * A restful way of controller users.
 */
class UsersController extends \BaseController {

    // User services provides a layer between controller and business logic
    protected $UserServices;

    /**
     * Constructor
     */
    public function __construct(UserServices $UserServices)
    {
        // Dependency Injection
        $this->UserServices = new UserServices();

        // Before Filters
        $this->beforeFilter('csrf', [
            'only' => [
                'post',
                'put',
                'destroy'
            ]
        ]); // Cross Site Request forgery prevention
        $this->beforeFilter('auth', [
            'only' => [
                'index',
                'show',
                'edit',
                'update',
                'destroy'
            ]
        ]); // User must be Authenticated to see these routes
        $this->beforeFilter('guest', [
            'only' => [
                'create',
                'store'
            ]
        ]); // Only Unauthenticated users can see this

    }

    /**
	 * Display a listing of the resource.
	 * GET /users
	 *
	 * @return Response
	 */
	public function index()
	{
		// Display All Users
	}

	/**
	 * Show the form for creating a new resource.
	 * GET /users/create
	 *
	 * @return Response
	 */
	public function create()
	{
        return View::make('account.signup');
	}

	/**
	 * Store a newly created resource in storage.
	 * POST /users
	 *
	 * @return Response
	 */
	public function store()
	{
        try {
            $this->UserServices->create(
                Input::only('username','firstname','lastname','email','password','password_confirmation'),
                Input::hasFile('avatar') ? Input::file('avatar') : null,
                true //todo:    Change activation email
            );
        }
        catch( UserServiceException $e) {
            return Redirect::route('account.signup')->withErrors($e->errors() )->withInput();
        }
        return Redirect::home()->withMessage('Please check your email to confirm activation');
	}

	/**
	 * Display the specified resource.
	 * GET /users/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
        $user = User::find($id)-> load('items','roles');

        // No need to populate permissions if the user has no roles
        if (! $user->roles->isEmpty() )
        {
            $user->roles->load('perms');
        }

        //todo: Update view location
        return View::make('account.profile')->withUser($user);
    }

	/**
	 * Show the form for editing the specified resource.
	 * GET /users/{id}/edit
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$user = User::find($id);
        return View::make('account.settings')->withUser($user);
	}

	/**
	 * Update the specified resource in storage.
	 * PUT /users/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
        try { $this->UserServices->update(
            $id,
            Input::only('username','firstname','lastname','email','password','password_confirmation'),
            Input::hasFile('avatar') ? Input::file('avatar') : null
        );
        }   // Attempt to update user
        catch (UserServiceException $e)
        {
            return Redirect::route('account.settings')
                ->withInput()
                ->withUser($e->user() )
                ->withErrors($e->errors() );
        }   // Validation Errors
        catch (UserNotFoundException $e)
        {
            return Redirect::home()->withError('Account does not exist');
        }   // User does not exist

        //Updated completed, redirect home
        return Redirect::home()->withMessage('Account updated');
	}

	/**
	 * Remove the specified resource from storage.
	 * DELETE /users/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
        if($user = User::find($id))
        {
            $user->delete();
            return Redirect::back()->withMessage('The account has been deleted');
        }
        return Redirect::back()->withError('No account found');
	}

}