<?php
/**
 * Created by PhpStorm.
 * User: jonathan
 * Date: 2020/5/7
 */

namespace App\ZenCart;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * Class Product
 * @property integer $products_id
 * @property integer $products_type
 * @property double $products_quantity
 * @property string $products_model
 * @property string $products_image
 * @property string $products_price
 * @property boolean $products_virtual
 * @property string $products_date_added
 * @property string $products_last_modified
 * @property string $products_date_available
 * @property double $products_weight
 * @property boolean $products_status
 * @property integer $products_tax_class_id
 * @property integer $manufacturers_id
 * @property double $products_ordered
 * @property double $products_quantity_order_min
 * @property double $products_quantity_order_units
 * @property boolean $products_priced_by_attribute
 * @property boolean $product_is_free
 * @property boolean $product_is_call
 * @property boolean $products_quantity_mixed
 * @property boolean $product_is_always_free_shipping
 * @property boolean $products_qty_box_status
 * @property double $products_quantity_order_max
 * @property integer $products_sort_order
 * @property boolean $products_discount_type
 * @property boolean $products_discount_type_from
 * @property string $products_price_sorter
 * @property integer $master_categories_id
 * @property boolean $products_mixed_discount_quantity
 * @property boolean $metatags_title_status
 * @property boolean $metatags_products_name_status
 * @property boolean $metatags_model_status
 * @property boolean $metatags_price_status
 * @property boolean $metatags_title_tagline_status
 * @package App\ZenCart\Models
 */
class Product extends Model
{

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'products';

    /**
     * @var string
     */
    protected $primaryKey = 'products_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'products_id',
        'products_type',
        'products_quantity',
        'products_model',
        'products_image',
        'products_price',
        'products_virtual',
        'products_date_added',
        'products_last_modified',
        'products_date_available',
        'products_weight',
        'products_status',
        'products_tax_class_id',
        'manufacturers_id',
        'products_ordered',
        'products_quantity_order_min',
        'products_quantity_order_units',
        'products_priced_by_attribute',
        'product_is_free',
        'product_is_call',
        'products_quantity_mixed',
        'product_is_always_free_shipping',
        'products_qty_box_status',
        'products_quantity_order_max',
        'products_sort_order',
        'products_discount_type',
        'products_discount_type_from',
        'products_price_sorter',
        'master_categories_id',
        'products_mixed_discount_quantity',
        'metatags_title_status',
        'metatags_products_name_status',
        'metatags_model_status',
        'metatags_price_status',
        'metatags_title_tagline_status'
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
     * 商品描述
     *
     * @return HasOne
     */
    public function description()
    {
        return $this->hasOne(ProductsDescription::class, 'products_id', 'products_id');
    }


    /**
     * 产品属性
     * @return HasMany
     */
    public function attributes()
    {
        return $this->hasMany(ProductsAttribute::class, 'products_id', 'products_id');
    }

    /**
     * 产品图集
     * @return HasMany
     */
    public function galleries()
    {
        return $this->hasMany(ProductsGallery::class, 'products_id', 'products_id');
    }

    /**
     * 所属分类
     *
     * @return BelongsToMany
     */
    public function categories()
    {
        return $this->belongsToMany(
            Category::class,
            'products_to_categories',
            'products_id',
            'categories_id',
            'products_id',
            'categories_id'
        );
    }


    /**
     * 图片链接
     * @return string
     */
    public function image()
    {
        return $this->products_image;
    }

}
