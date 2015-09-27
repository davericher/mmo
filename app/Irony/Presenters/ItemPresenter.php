<?php namespace Irony\Presenters;

use Illuminate\Support\Str;

/**
 * Class ItemPresenter
 * Display information from Item model to end user
 * @package Irony\Presenters
 */
class ItemPresenter extends Presenter
{
    static private $metaType = "website";

    public function name()
    {
        return ucwords($this->entity->name);
    }
    public function amount()
    {
        return money($this->entity->amount);
    }
    public function shortDesc()
    {
        return STR::limit($this->entity->description,60);
    }
    public function shortName()
    {
        return STR::limit($this->entity->name,20);
    }

    public function photoSrc($style = "original")
    {
        return $this->entity->photo->url($style);
    }

    /**
     * Meta Presenters
     */
    public function metaOgTitle()
    {
        return ucwords($this->entity->name);
    }
    public function metaOgType()
    {
        return static::$metaType;
    }
    public function metaOgUrl()
    {
        return route('items.show',$this->entity->id);
    }
    public function metaOgImage($style="original") {
        return  $this->photoSrc($style);
    }
    public function metaOgDescription() {
        return STR::limit( $this->amount() . ' | '
        . $this->entity->user->present()->username . ' | '
        . $this->entity->description,300);
    }
    public function metaOgUpdated()
    {
        return $this->entity->updated_at;
    }


}