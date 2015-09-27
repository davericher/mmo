<?php namespace Irony\Presenters\Contracts;

interface PresentableInterface 
{
	public function present();
    public function getPresentAttribute();
}