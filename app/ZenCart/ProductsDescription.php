<?php

namespace App\ZenCart;

/**
 * Class ProductsDescription
 * @property integer $products_id
 * @property integer $language_id
 * @property string $products_name
 * @property string $products_description
 * @property string $products_url
 * @property integer $products_viewed
 * @package App\ZenCart
 */
class ProductsDescription extends Model
{

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'products_description';

    /**
     * @var null
     */
    protected $primaryKey = null;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
		'products_id',
		'language_id',
		'products_name',
		'products_description',
		'products_url',
		'products_viewed'
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
