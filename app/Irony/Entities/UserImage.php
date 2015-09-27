<?php namespace Irony\Entities;

/**
 * Images for Irony\Entities\User
 * Class UserImage
 * @package Irony\Entities
 */
class UserImage extends Image {
    protected $imageStyles = [
        'thumb' => '50x50',
        'content-box' => '350x263#',
        'edit-box'  =>  '467'
    ];
    protected $imageRoot = 'userimages';
	protected $fillable = ['image_description'];
    protected $table = 'user_images'; // The database table used by the model

    public function user(){
        return $this->belongsTo('Irony\Entities\User');
    }

}