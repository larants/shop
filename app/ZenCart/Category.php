<?php

namespace App\ZenCart;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * Class Category
 * @property integer $categories_id
 * @property string $categories_image
 * @property integer $parent_id
 * @property integer $sort_order
 * @property string $date_added
 * @property string $last_modified
 * @property boolean $categories_status
 * @package App\ZenCart
 */
class Category extends Model
{

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'categories';

    protected $primaryKey = 'categories_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
		'categories_id',
		'categories_image',
		'parent_id',
		'sort_order',
		'date_added',
		'last_modified',
		'categories_status'
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
     * 分类描述
     * @return HasOne
     */
    public function description()
    {
        return $this->hasOne(CategoriesDescription::class, 'categories_id', 'categories_id');
    }

    /**
     * 父分类
     *
     * @return BelongsTo
     */
    public function parent()
    {
        return $this->belongsTo(Category::class, 'categories_id', 'parent_id');
    }

}
