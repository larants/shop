<?php

namespace App\ZenCart;

/**
 * Class CategoriesDescription
 * @property integer $categories_id
 * @property integer $language_id
 * @property string $categories_name
 * @property string $categories_description
 * @package App\ZenCart
 */
class CategoriesDescription extends Model
{

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'categories_description';

    /**
     * @var string
     */
    protected $primaryKey = 'categories_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
		'categories_id',
		'language_id',
		'categories_name',
		'categories_description'
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
