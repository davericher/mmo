<?php
use Irony\Entities\User; // used for ardent remember me work around

/**
 * Class SessionController
 * Control the users authentication process.
 */
class SessionController extends \BaseController {
    /**
     * Constructor -- Add appropriate filters
     */
    public function __construct()
{       parent::__construct();
        $this->beforeFilter('guest', [
           'only' => [
               'create'
           ]
        ]);
    }

    /**
     * Display the sign in page
     * @return \Illuminate\View\View
     */
    public function create()
	{
        return View::make('session.create');
	}

    /**
     * Process user input and authenticate
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store()
	{
        // Work around for ardent and remember me token
        if ( Auth::attempt( [
            'email'     =>  Input::get('email'),
            'password'  =>  Input::get('password'),
            'active'    =>  true
        ], Input::has('remember') ? true : false ) )
        {
            return Redirect::intended()->withMessage(Lang::get('sessions.signin'));
        }
        else
        {
            return Redirect::route('session.create')
                ->withError(Lang::get('sessions.error'))
                ->withInput();
        }
	}

    /**
     * Restfully sign the user out
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy()
	{
        // Work around for ardent and remember me token
        Auth::logout();
        return Redirect::intended()->withMessage(Lang::get('sessions.signout'));
	}


}