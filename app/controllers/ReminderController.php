<?php
use Irony\Services\UserServices;
use Irony\Services\Exceptions\UserServiceException;

/**
 * Class ReminderController
 * Responsible for the user password reset processes.
 */
class ReminderController extends \BaseController {

    protected $UserServices;

    /**
     * Constructor:
     */
    public function __construct(UserServices $UserServices)
    {
        $this->UserServices = $UserServices;
        parent::__construct();

        $this->beforeFilter('guest', [
            'except' => [
                'create',
                'store',
                'show',
                'destroy'
            ]
        ]);
    }


	/**
	 * Show the form for creating a new resource.
	 * GET /reminder/create
	 *
	 * @return Response
	 */
	public function create()
	{
        return View::make('reminder.create');
    }

	/**
	 * Store a newly created resource in storage.
	 * POST /reminder
	 *
	 * @return Response
	 */
	public function store()
	{
        /// Set email subject
        $response = Password::remind(Input::only('email'), function($message){
            $message->subject(Lang::get('reminders.subject'));
        });

        switch ( $response )
        {
            case Password::INVALID_USER:
                return Redirect::back()->withError(Lang::get($response));
            case Password::REMINDER_SENT:
                return Redirect::home()->withMessage(Lang::get('reminders.sent'));
            default:
                return Redirect::home()->withError(Lang::get('reminders.error'));
        }
	}


    /**
     * Display the specified resource.
     * GET /reminder/{id}
     *
     * @param null $token
     * @internal param int $id
     * @return Response
     */
	public function show($token = null)
	{
        if (is_null($token)) App::abort(404);
        Former::withRules(Irony\Entities\User::$rules);
        return View::make('reminder.show')->withToken($token);
	}


    /**
     * Remove the specified resource from storage.
     * DELETE /reminder/{id}
     *
     * @internal param int $id
     * @return Response
     */
	public function destroy()
	{
        try {
            switch ($response = $this->UserServices->reset(
                Input::only('email','password','password_confirmation','token')
            ))
            {
                case Password::PASSWORD_RESET:
                    return Redirect::home()->withMessage('Password has been reset');
                case Password::INVALID_PASSWORD:
                case Password::INVALID_TOKEN:
                case Password::INVALID_USER:
                    return Redirect::back()
                        ->withErrors(Lang::get($response));
                default:
                    return Redirect::back()
                        ->withErrors(Lang::get($response));

            }
        }
            // Catch any errors Laravel 4.1s Password reminder did not catch
        catch (UserServiceException $e)
        {
            return Redirect::back()->withErrors( $e->errors() );
        }
	}

}