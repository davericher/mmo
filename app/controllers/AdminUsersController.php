<?php

use Irony\Entities\User;
use Irony\Services\UserServices;
use Irony\Services\Exceptions\UserServiceException;
use Irony\Services\Exceptions\UserNotFoundException;


/**
 * Class UsersController
 * todo:Somehow faze this all out
 */
class AdminUsersController extends \BaseController {

    protected $UserServices;

    /**
     * Layout Configuration
     */
    protected $layout = "layouts.master";

    /**
     * Class Constructor
     */
    public function __construct(UserServices $userServices)
	{
	    parent::__construct();
        $this->beforeFilter('auth');
        $this->beforeFilter('isRoot');
        $this->UserServices = $userServices;

	}


	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
        //todo: use in different classes
        if ($search = Request::get('u'))
        {
            $users = Search::users($search);
            if ( $users->count() )
            {
                return View::make('admin.users.index')->withUsers($users);
            }
            return Redirect::route('admin.users.index')->withError('No users found');

        }
        $users = User::withTrashed()->where('id','!=',Auth::user()->id)->get();
        return View::make('admin.users.index')->withUsers($users);
	}


	/** 
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		if ($user = User::find($id))
		{
			return View::make('account.settings')->withUser($user);
		}
		return Redirect::route('admin.users.index')->withError('No Such user');
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
			try { $this->UserServices->update($id,  Input::all()); }
			catch (UserServiceException $e)
			{
				return Redirect::route('admin.users.edit',$id)->withInput()->withErrors( $e->errors() );
			}

		    //Redirect them to login page
			return Redirect::back()->withMessage('The account has been modified')->withInput();
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function suspend($id)
	{
        try {
            $this->UserServices->suspend($id);
            return Redirect::back()->withMessage('The account has been suspended');
        }
        catch (UserNotFoundException $e)
        {
            return Redirect::back()->withError('No account found');
        }
	}

    public function destroy($id)
    {
        try {
            $this->UserServices->delete($id);
            return Redirect::back()->withMessage('The account has been deleted');
        }
        catch (UserNotFoundException $e)
        {
            return Redirect::back()->withError('No account found');
        }
    }

    public function active($id)
    {
        try {
            $this->UserServices->switchActive($id);
            return Redirect::back()->withMessage('Operation successful');
        }
        catch (UserNotFoundException $e)
        {
            return Redirect::back()->withError('No account found');
        }
    }

    public function restore($id)
    {
        try {
            $this->UserServices->restore($id);
            return Redirect::route('admin.users.index')->withMessage('The account has been restored');
        }
        catch (UserNotFoundException $e)
        {
            return Redirect::route('admin.users.index')->withError('No account found');
        }
    }




}