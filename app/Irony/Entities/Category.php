<?php namespace Irony\Entities;

use Illuminate\Support\Str;

use Irony\Presenters\Contracts\PresentableInterface;
use Irony\Presenters\PresentableTrait;

/**
 * Class Category
 * @package Irony\Entities
 */
class Category extends BaseEntitie  implements PresentableInterface {
    /**
     * Implementation configuration
     */
    use PresentableTrait;
    protected $presenter = 'Irony\Presenters\CategoryPresenter';

    /* Base Config */
    protected $table = 'categories'; // The database table used by the model
    protected $fillable = ['name'];

    public static $rules = [
        'name'  => 'required|unique:categories|max:24'
    ];

    /**
     * Return a slugged version of the category name
     * @return string
     */
    public function getSlugAttribute()
    {
        return STR::slug($this->name);
    }

    public function items() {
        return $this->belongsToMany('Irony\Entities\Item');
    }

}