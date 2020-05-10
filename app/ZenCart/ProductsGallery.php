<?php

namespace App\ZenCart;

/**
 * Class ProductsGallery
 * @property integer $id
 * @property integer $products_id
 * @property string $color_code
 * @property string $path
 * @property integer $order
 * @property integer $index
 * @property string $sku
 * @property boolean $status
 * @property integer $color
 * @package App\ZenCart
 */
class ProductsGallery extends Model
{

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'products_gallery';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
		'products_id',
		'color_code',
		'path',
		'order',
		'index',
		'sku',
		'status',
		'color'
	];

    /**
      * The attributes that should be hidden for arrays.
      *
      * @var array
      */
     protected $hidden = [];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [];

}
