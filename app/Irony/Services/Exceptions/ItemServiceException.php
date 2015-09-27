<?php namespace Irony\Services\Exceptions;

use Exception;

use Irony\Entities\Item;

/**
 * Class ItemServiceException
 * @package Irony\Services\Exceptions
 */
class ItemServiceException extends Exception  {

		protected  $user;
        protected  $errors;

    /**
     * @param \Irony\Entities\Item
     */
    public function __construct(Item $item) {

	    	$this->item = $item;
            $this->errors = $item->errors()->all();

            // make sure everything is assigned properly
            parent::__construct('ItemServiceException', 0, null);
	    }

    /**
     * @return \Irony\Entities\Item
     */
    public function item()
    {
        return $this->item;
    }

    /**
     * @return array
     */
    public function errors()
    {
        return $this->errors;
    }
    
}