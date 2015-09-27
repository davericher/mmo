<?php
namespace Irony\Entities;

use LaravelBook\Ardent\Ardent;

use Irony\Utilities\Filter;


abstract class BaseEntitie extends ardent {

    /**
     * Attributes to filter profanity of
     * @var array
     */
    protected $filtered = [];
    protected $filterReplace = '@$%#';

    /**
     * @param string $key
     * @param mixed $value
     */
    public function setAttribute($key, $value)
    {
        if (in_array($key, $this->filtered)) {
            $filter = new Filter;
            $value = $filter->filter($value, $this->filterReplace);
        }

        parent::setAttribute($key, $value);
    }

    /**
     * Returns false if Model does not use timestamps
     * or was not updated
     * Returns true if Model uses timestamps and has
     * been updated
     * @return bool
     */
    public function isUpdated()
    {
        return $this->timestamps && $this->{static::CREATED_AT} != $this->{static::UPDATED_AT};
    }

    /**
     * Restore a soft-deleted model instance.
     * Adapted for Ardent
     *
     * @return bool|null
     */
    public function restore()
    {
        if ($this->softDelete)
        {
            // If the restoring event does not return false, we will proceed with this
            // restore operation. Otherwise, we bail out so the developer will stop
            // the restore totally. We will clear the deleted timestamp and save.
            if ($this->fireModelEvent('restoring') === false)
            {
                return false;
            }

            $this->{static::DELETED_AT} = null;

            // Once we have saved the model, we will fire the "restored" event so this
            // developer will do anything they need to after a restore operation is
            // totally finished. Then we will return the result of the save call.
            $result = $this->forceSave();

            $this->fireModelEvent('restored', false);

            return $result;
        }
    }

} 