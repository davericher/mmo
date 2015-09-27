<?php namespace Irony\Presenters;

use Irony\Presenters\Exceptions\PresenterException;

trait PresentableTrait 
{
	protected  $presenterInstance;

	public function present()
	{
		if (!$this->presenter or !class_exists($this->presenter))
			throw new PresenterException('Please set the $protected property to your presenter path.');

		if (! $this->presenterInstance)
			$this->presenterInstance = new $this->presenter($this);

		return $this->presenterInstance;
	}

    public function getPresentAttribute()
    {
        return $this->present();
    }

}