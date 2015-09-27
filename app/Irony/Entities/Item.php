<?php namespace Irony\Entities;

use Irony\Presenters\Contracts\PresentableInterface;
use Irony\Presenters\PresentableTrait;
use Illuminate\Database\Eloquent\SoftDeletingTrait;
/**
 * Class Item
 * @package Irony\Entities
 */
class Item extends BaseEntitie implements PresentableInterface {

    /**
     * Implementation configuration
     */
    use PresentableTrait;
    protected $presenter = 'Irony\Presenters\ItemPresenter';

    use SoftDeletingTrait;

    /**
     * Security
     */
    protected $fillable = ['name','description','amount'];
    protected $filtered = ['description'];

    /* Ardent Configuration */
    protected $table = 'items'; // The database table used by the model
	public $autoPurgeRedundantAttributes = true; // Purge non persisted Data
	public static $rules = [
		'user_id'       =>  'required|integer|exists:users,id',
        'category_id'   =>  'required|integer|exists:categories,id',
	    'name'          =>  'required|min:2|max:24',
	    'description'   =>  'required|max:2000',
        'amount'        =>  'required|numeric|min:0|max:10000',
    ];
    public static $photoRules = [ 'photo' => 'required|image|max:51200' ]; // Photo Validation rules
    public static $photoUpdateRules = ['photo' => 'image|max:51200']; // Photo Update rules

    /**
     * Get the primary photo
     * @return mixed
     */
    public function getPhotoAttribute()
    {
        if (!$this->images->isEmpty())
            return $this->images->first()->image;
        return false;
    }

    /**
     * Set the User Avatar
     * @param $photo
     * @internal param $avatar
     */
    public function setPhotoAttribute($photo)
    {
        if ($this->photo)
        {
            $this->images->first()->image->clear();
            $this->images->first()->image = $photo;
            $this->images->first()->save();
        }
        else
        {
            $image = new ItemImage();
            //todo Try this in reverse
            $image->image = $photo;
            $image->item()->associate($this);
            $this->images()->save($image);
        }
    }
    /** Search Scope
     * Searches by Item name and Description
     * @param $query
     * @param $search
     * @return mixed
     */
    public function scopeSearch($query, $search)
    {
        return $query->where(function($query) use ($search)
        {
            $query
                ->where('name','LIKE',"%$search%")
                ->orWhere('description','LIKE',"%$search%");
        });
    }

    public function user() {
        return $this->belongsTo('Irony\Entities\User');
    }
    public function images() {
        return $this->hasMany('Irony\Entities\ItemImage');
    }
    public function comments() {
        return $this->hasMany('Irony\Entities\Comment');
    }
    public function category() {
        return $this->belongsTo('Irony\Entities\Category');
    }

}