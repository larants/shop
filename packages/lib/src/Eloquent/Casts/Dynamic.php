<?php
/**
 * Created by PhpStorm.
 * User: jonathan
 * Date: 2020/3/4
 */

namespace Leading\Lib\Eloquent\Casts;


use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Leading\Lib\Eloquent\DynamicManager;
use Leading\Lib\Eloquent\Model;

/**
 * Class Dynamic
 * @package Leading\Lib\Eloquent\Casts
 */
class Dynamic implements CastsAttributes
{

    /**
     * @param Model $model
     * @param string $key
     * @param mixed $value
     * @param array $attributes
     * @return DynamicManager
     */
    public function get($model, string $key, $value, array $attributes)
    {
        return new DynamicManager($model, $key);
    }

    /**
     * @param Model $model
     * @param string $key
     * @param mixed $value
     * @param array $attributes
     * @return array|false|string
     */
    public function set($model, string $key, $value, array $attributes)
    {
        return json_encode($value);
    }
}