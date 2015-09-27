<?php namespace Irony\Services\Exceptions;
use Exception;

/**
 * Class ImageValidationException
 * @package Irony\Services\Exceptions
 */
class ImageValidationException extends Exception  {

    protected  $errors;

    /**
     * @param array $errors
     * @internal param \Irony\Services\Exceptions\User $user
     */
    public function __construct(array $errors) {

        $this->errors = $errors;

        // make sure everything is assigned properly
        parent::__construct('ImageValidationException', 0, null);
    }

    public function errors()
    {
        return $this->errors;
    }

}
