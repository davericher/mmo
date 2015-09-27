<?php namespace Irony\Entities;
use Codesleeve\Stapler\Stapler;

/**
 * Class Image
 * Base Image Entity.
 * @package Irony\Entities
 */
abstract class Image extends BaseEntitie {
    use Stapler;

    /**
     * Stapler style array
     * @var array
     */
    protected $imageStyles = [];
    /**
     * Image Path relative to Stapler root
     * @var string
     */
    protected $imageRoot = '';
    /**
     * Image object attachment attribute
     * @var string
     */
    protected $imageObject = 'image';
    /**
     * Class constructor, attaches stapler 'image' object
     * @param array $attributes
     */
    public function __construct(array $attributes = array()) {
        $imageRoot = !empty($this->imageRoot) ? $this->imageRoot : ':class';
        $this->hasAttachedFile($this->imageObject, [
            'styles' => $this->imageStyles,
            'url' => '/system/'. $imageRoot .'/:id_partition/:style/:filename',
            'default_url' => '/system/'. $imageRoot .'/:style/missing.png' // Create this
        ]);

        parent::__construct($attributes);
    }
} 