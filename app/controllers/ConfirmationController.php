<?php
use Irony\Services\UserServices;

use Irony\Services\Exceptions\UserServiceException;
use Irony\Services\Exceptions\UserNotFoundException;

/**
 * Class ConfirmationController
 * Handles the confirmation request to activate users accounts.
 */
class ConfirmationController extends \BaseController {

    protected   $UserServices;

    /**
     * Initialize Controller and substantiate UserServices
     * @param UserServices $UserServices
     */
    public function __construct ( UserServices $UserServices)
    {
        parent::__construct();
        $this->UserServices = $UserServices;
        $this->beforeFilter('guest', [
            'only' => [
                'show'
            ]
        ]);
        $this->beforeFilter('auth|isRoot', [
            'only' => [
                'update'
            ]
        ]);

    }


	/**
	 * Display the specified resource.
	 * GET /confirmation/{token}
	 *
	 * @param  int  $token
	 * @return Response
	 */
	public function show($token = null)
	{
        if (is_null($token))
            return Redirect::route('account.signup')->withError(Lang::get('confirmation.error'));
        try { $this->UserServices->confirm($token) ;}
        catch( UserServiceException $e)
        {
            return Redirect::route('account.signup')->withError(Lang::get('confirmation.error'))->withErrors($e->errors() );
        }
        catch ( UserNotFoundException $e)
        {
            return Redirect::route('account.signup')->withError(Lang::get('confirmation.error'));
        }
        return Redirect::route('session.create')->withMessage(Lang::get('confirmation.activated'));
	}

    public function update($id)
    {

    }

}