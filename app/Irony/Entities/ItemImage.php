<?php namespace Irony\Entities;

/**
 * Images for Irony\Entities\User
 * Class UserImage
 * @package Irony\Entities
 */
class ItemImage extends Image {
    protected $imageStyles = [
        'thumb' => '50x50',
        'content-box' => '720x480#',
        'edit-box'  =>  '467',
        'full-size' =>  '1140x640#',
        'modal' => '1140'
    ];
    protected $imageRoot = 'itemimages';
	protected $fillable = ['image_description'];
    protected $table = 'item_images'; // The database table used by the model

    public function item() {
        return $this->belongsTo('Irony\Entities\Item');
    }
}