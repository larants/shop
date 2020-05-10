<?php

namespace App\ZenCart;

/**
 * Class ProductsOptionsValue
 * @property integer $products_options_values_id
 * @property integer $language_id
 * @property string $products_options_values_name
 * @property integer $products_options_values_sort_order
 * @package App\ZenCart
 */
class ProductsOptionsValue extends Model
{

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'products_options_values';

    /**
     * @var string
     */
    protected $primaryKey = 'products_options_values_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
		'products_options_values_id',
		'language_id',
		'products_options_values_name',
		'products_options_values_sort_order'
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
