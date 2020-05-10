<?php

namespace App\ZenCart;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class ProductsAttribute
 * @property integer $products_attributes_id
 * @property integer $products_id
 * @property integer $options_id
 * @property integer $options_values_id
 * @property string $options_values_price
 * @property string $price_prefix
 * @property integer $products_options_sort_order
 * @property boolean $product_attribute_is_free
 * @property double $products_attributes_weight
 * @property string $products_attributes_weight_prefix
 * @property boolean $attributes_display_only
 * @property boolean $attributes_default
 * @property boolean $attributes_discounted
 * @property string $attributes_image
 * @property boolean $attributes_price_base_included
 * @property string $attributes_price_onetime
 * @property string $attributes_price_factor
 * @property string $attributes_price_factor_offset
 * @property string $attributes_price_factor_onetime
 * @property string $attributes_price_factor_onetime_offset
 * @property string $attributes_qty_prices
 * @property string $attributes_qty_prices_onetime
 * @property string $attributes_price_words
 * @property integer $attributes_price_words_free
 * @property string $attributes_price_letters
 * @property integer $attributes_price_letters_free
 * @property boolean $attributes_required
 * @package App\ZenCart
 */
class ProductsAttribute extends Model
{

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'products_attributes';

    /**
     * @var string
     */
    protected $primaryKey = 'products_attributes_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'products_attributes_id',
        'products_id',
        'options_id',
        'options_values_id',
        'options_values_price',
        'price_prefix',
        'products_options_sort_order',
        'product_attribute_is_free',
        'products_attributes_weight',
        'products_attributes_weight_prefix',
        'attributes_display_only',
        'attributes_default',
        'attributes_discounted',
        'attributes_image',
        'attributes_price_base_included',
        'attributes_price_onetime',
        'attributes_price_factor',
        'attributes_price_factor_offset',
        'attributes_price_factor_onetime',
        'attributes_price_factor_onetime_offset',
        'attributes_qty_prices',
        'attributes_qty_prices_onetime',
        'attributes_price_words',
        'attributes_price_words_free',
        'attributes_price_letters',
        'attributes_price_letters_free',
        'attributes_required'
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
     * @return BelongsTo
     */
    public function option()
    {
        return $this->belongsTo(ProductsOption::class, 'options_id', 'products_options_id');
    }

    /**
     * @return BelongsTo
     */
    public function optionValue()
    {
        return $this->belongsTo(
            ProductsOptionsValue::class,
            'options_values_id',
            'products_options_values_id'
        );
    }

}
