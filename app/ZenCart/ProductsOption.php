<?php

namespace App\ZenCart;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Leading\Lib\Eloquent\Model;

/**
 * Class ProductsOption
 * @property integer $products_options_id
 * @property integer $language_id
 * @property string $products_options_name
 * @property integer $products_options_sort_order
 * @property integer $products_options_type
 * @property integer $products_options_length
 * @property string $products_options_comment
 * @property integer $products_options_size
 * @property integer $products_options_images_per_row
 * @property integer $products_options_images_style
 * @property integer $products_options_rows
 * @property integer $products_options_where
 * @package App\ZenCart
 */
class ProductsOption extends Model
{

    /**
     * @var string
     */
    protected $table = 'products_options';

    /**
     * @var string
     */
    protected $primaryKey = 'products_options_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
		'products_options_id',
		'language_id',
		'products_options_name',
		'products_options_sort_order',
		'products_options_type',
		'products_options_length',
		'products_options_comment',
		'products_options_size',
		'products_options_images_per_row',
		'products_options_images_style',
		'products_options_rows',
		'products_options_where'
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

    /**
     * @return BelongsToMany
     */
    public function values()
    {
        return $this->belongsToMany(
            ProductsOptionsValue::class,
            'products_options_values_to_products_options',
            'products_options_id',
            'products_options_values_id',
            'products_options_id',
            'products_options_values_id'
        );
    }

}
