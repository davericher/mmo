<?php namespace Irony\Services;

use Illuminate\Support\Facades\Validator;

use Irony\Services\Exceptions\ImageValidationException;
use Irony\Services\Exceptions\ItemNotFoundException;
use Irony\Services\Exceptions\ItemPhotoNotFoundException;
use Irony\Services\Exceptions\ItemServiceException;

use Irony\Entities\Item;
use Irony\Entities\User;
/**
 * Class ItemServices
 * @package Irony\Services
 * Handles Image services
 */
class ItemServices {
    static $paginate = 11; // Results per page
    static $commentsPaginate = 5;

    /**
     * @param \Illuminate\Auth\UserInterface|User $user
     * @param array $input
     * @throws Exceptions\ImageValidationException
     * @throws Exceptions\ItemServiceException
     * @return Item
     */
    public function create( User $user, array $input)
    {
        $val = Validator::make($input,Item::$photoRules);

        //Create the item
        $item = new Item;
        $item->name = $input['name'];
        $item->description = $input['description'];
        $item->amount = $input['amount'];
        $item->user()->associate($user);
        $item->category_id = $input['categories'];
        //Check if Image exists
        if ($val->fails())
        {
            $item->validate(); // Check to see if there are also any validation errors on item
            throw new ImageValidationException(array_merge($val->messages()->all(),$item->errors()->all()));
        }

        //Check if item saved ok
        if (! $item->save() )
            throw new ItemServiceException($item);

        $item->photo = $input['photo'];

        //Return the created item
        return  $item;
    }

    /**
     * @param $item_id
     * @param array $input
     * @return bool
     * @throws Exceptions\ImageValidationException
     * @throws Exceptions\ItemNotFoundException
     * @throws Exceptions\ItemServiceException
     */
    public function update ($item_id, array $input)
    {
        $item = Item::whereId($item_id)->first();

        if (! empty($item) )
        {
            $item->name = $input['name'];
            $item->description = $input['description'];
            $item->amount = $input['amount'];
            $item->category_id = $input['categories'];

            //Change the Photo if a new one was provided
            if (! empty($input['photo']))
            {
                $val = Validator::make($input,Item::$photoRules);
                //Image Validation
                if ($val->fails())
                {
                    $item->validate(); // Check to see if there are also any validation errors on item
                    throw new ImageValidationException(array_merge($val->messages()->all(),$item->errors()->all()));
                }
                $item->photo = $input['photo'];
            }
            if (! $item->save())
                throw new ItemServiceException($item);
        }
        else
            throw new ItemNotFoundException();

        return true;
    }

    /**
     * @param $item_id
     * @return bool
     * @throws Exceptions\ItemNotFoundException
     */
    public function destroy ($item_id)
    {
        $item = Item::whereId($item_id)->first();
        if (! empty($item))
        {
            $item->photo->clear();
            $item->forceDelete();
            return true;
        }
        else
        {
            throw new ItemNotFoundException();
        }
    }

}