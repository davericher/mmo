<?php namespace Irony\Entities;

use Irony\Entities\EntityTraits\UserLaravelTrait;

use Illuminate\Auth\Reminders\RemindableInterface;
use Illuminate\Auth\UserInterface;
use Illuminate\Database\Eloquent\SoftDeletingTrait;

use Irony\Presenters\Contracts\PresentableInterface;
use Irony\Presenters\PresentableTrait;

use Zizaco\Entrust\HasRole;

/**
 * Class User
 *
 * @package Irony\Entities
 *
 **/
class User extends BaseEntitie implements UserInterface, RemindableInterface, PresentableInterface
{
    /**
     * Implementation configuration
     */
    use HasRole;
    use PresentableTrait;
    use UserLaravelTrait;
    use SoftDeletingTrait;

    protected $presenter = 'Irony\Presenters\UserPresenter';

    /* Validation Rules */
    public static $rules = [
        'username' => 'required|unique:users|min:2|max:20',
        'firstname' => 'required|alpha|min:2|max:20',
        'lastname' => 'required|alpha|min:2|max:20',
        'email' => 'required|email|unique:users|max:100',
        'password' => 'required|between:6,20|confirmed',
        'password_confirmation' => 'required|between:6,20',
        'token' => 'max:64|unique:users'
    ]; // Model Rules
    public static $nopassRules = [
        'username' => 'required|unique:users|min:2|max:20',
        'firstname' => 'required|alpha|min:2|max:20',
        'lastname' => 'required|alpha|min:2|max:20',
        'email' => 'required|email|unique:users|max:100'
    ]; // Model with No password rules
    public static $avatarRules = [ 'avatar' => 'image|max:2560' ]; // Avatar Validation rules

    /* Auto hashed attributes */
    public static $passwordAttributes = ['password','password_confirmation'];

    /* General Config */
    protected $table = 'users'; // The database table used by the model
    protected $fillable = ['firstname', 'lastname', 'email', 'username', 'password','password_confirmation']; // Mass Assignment prevention reverse $gaurded
    protected $hidden = ['password', 'token','remember_token']; // The attributes excluded from the model's JSON form.
    protected $softDelete = true;

    /* Ardent Configuration */
    public $autoHashPasswordAttributes = true; // Set autoHash on or off
    public $autoPurgeRedundantAttributes = true; // Purge non persisted Data
    public $autoHydrateEntityFromInput = true; // hydrates on new entries' validation
    public $forceEntityHydrationFromInput = true; // hydrates whenever validation is called

    /**
     * Observables
     * Implemented: Deleted, Restoring
     */
    public static function boot()
    {
        parent::boot();
        static::deleting(function ($user) {

            /** Soft Delete all the users Items */
            /** set the deleted at rather then deleting to prevent stapler from deleting file */
            if ($user->items) {
                foreach ($user->items as $item) {
                    $item->delete();
                }
            }
            return true;
        });

        static::restoring(function ($user) {
            /** Restore all the uses items, actually works, no longer returns false regardless*/
           $deletedItems = $user->items()->onlyTrashed()->get();
           if ($deletedItems->count()) {
                foreach ($deletedItems as $item) {
                    $item->restore();
                }
            }
        });

    }

    /**
     * Get the Avatar
     * @return mixed
     */
    public function getAvatarAttribute()
    {
        if (!$this->images->isEmpty())
            return $this->images->first()->image;
        return false;
    }


    /**
     * Set the User Avatar
     * @param $avatar
     */
    public function setAvatarAttribute($avatar)
    {
        if ($this->avatar)
        {
            $this->images->first()->image->clear();
            $this->images->first()->image = $avatar;
            $this->images->first()->save();
        }
        else
        {
            $image = new UserImage();
            //todo Try this in reverse
            $image->image = $avatar;
            $image->user()->associate($this);
            $this->images()->save($image);
        }
    }

    /** Search Scope
     * Searches by username
     * @param $query
     * @param $search
     * @return mixed
     */
    public function scopeSearch($query, $search)
    {
        return $query->where(function($query) use ($search)
        {
            $query->where('username','LIKE',"%$search%");
        });
    }

    public function items() {
        return $this->hasMany('Irony\Entities\Item');
    }
    public function images() {
        return $this->hasMany('Irony\Entities\UserImage');
    }
    public function comments() {
        return $this->hasMany('Irony\Entities\Comment');
    }

}