<?php namespace Irony\Services\Exceptions;

use Exception;

use Irony\Entities\User;

/**
 * Class UserServiceException
 * @package Irony\Services\Exceptions
 */
class UserServiceException extends Exception  {

		protected  $user;
        protected  $errors;

    /**
     * @param User $user
     */
    public function __construct(User $user) {

	    	$this->user = $user;
            $this->errors = $user->errors()->all();

            // make sure everything is assigned properly
            parent::__construct('UserServiceException', 0, null);
	    }

    /**
     * @return string
     */
    public function user()
    {
        return $this->user;
    }

    public function errors()
    {
        return $this->errors;
    }
    
}