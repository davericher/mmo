<?php namespace Irony\Entities;

use Irony\Presenters\Contracts\PresentableInterface;
use Irony\Presenters\PresentableTrait;


/**
 * Class Comment
 * Item comments.
 * @package Irony\Entities
 */
class Comment extends BaseEntitie implements PresentableInterface{

    protected $table = 'comments'; // The database table used by the model
	protected $fillable = ['body'];

    /**
     * Attributes to filter profanity of
     * @var array
     */
    protected $filtered = ['body'];

    /**
     * Implementation configuration
     */
    use PresentableTrait;
    protected $presenter = 'Irony\Presenters\CommentPresenter';


    /* Ardent Configuration */
    public $autoPurgeRedundantAttributes = true; // Purge non persisted Data
    public $autoHydrateEntityFromInput = true; // hydrates on new entries' validation
    public $forceEntityHydrationFromInput = true; // hydrates whenever validation is called

    public static $rules = [
        'user_id'=>'required|integer|exists:users,id',
        'item_id'=>'required|integer|exists:items,id',
        'body'=>'required|min:2|max:1000',
    ];

    public function user() {
        return $this->belongsTo('Irony\Entities\User');
    }
    public function item() {
        return $this->belongsTo('Irony\Entities\Item');
    }

}