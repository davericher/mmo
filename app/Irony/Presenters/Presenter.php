<?php namespace Irony\Presenters;

abstract class Presenter 
{
	protected $entity;

	function __construct($entity)
	{
		$this->entity = $entity;
	}

	public function __get($property)
	{
		if (method_exists($this, $property))
		{
			return $this->{$property}();
		}
		return $this->entity->{$property};
	}


    /**
     * @return mixed
     */
    public function created_at()
    {
        return $this->entity->created_at->diffForHumans();
    }

    /**
     * @return mixed
     */
    public function updated_at()
    {
        return $this->entity->updated_at->diffForHumans();
    }

}