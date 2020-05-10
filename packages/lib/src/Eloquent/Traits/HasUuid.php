<?php
/**
 * Created by PhpStorm.
 * User: jonathan
 * Date: 2018-12-11
 */

namespace Leading\Lib\Eloquent\Traits;

use Illuminate\Support\Str;
use Leading\Lib\Eloquent\Model;

/**
 * Trait HasUuid
 * @package Leading\Lib\Eloquent\Traits
 */
trait HasUuid
{

    /**
     * The attributes that should be change to uuid.
     *
     * @var array
     */
    protected $uuidFields = [];

    /**
     * init uuid
     */
    public static function bootHasUuid()
    {
        /* @var Model $model */
        self::creating(function ($model) {
            collect($model->uuidFields ?? [])->each(function ($field) use ($model) {
                if (!$model->{$field}) {
                    $model->{$field} = Str::uuid()->toString();
                }
            });

            if (empty($model->{$model->primaryKey}) && $model->keyType == 'string') {
                $model->{$model->primaryKey} = Str::uuid()->toString();
            }
        });
    }
}