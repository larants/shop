<?php
/**
 * Created by PhpStorm.
 * User: jonathan
 * Date: 2019-07-12
 */

namespace Leading\Lib\Eloquent;

use Illuminate\Support\Arr;

/**
 * Class DynamicManager
 * @package Leading\Lib\Eloquent
 */
class DynamicManager
{
    protected $model;

    protected $field;

    /**
     * DynamicFieldManager constructor.
     * @param Model $model
     * @param string $field
     */
    public function __construct($model, string $field)
    {
        $this->model = $model;
        $this->field = $field;
    }

    /**
     * @return array
     */
    public function all(): array
    {
        return $this->model->{$this->field} ?: [];
    }

    /**
     * @param string $path
     * @return bool
     */
    public function has(string $path): bool
    {
        return Arr::has($this->all(), $path);
    }

    /**
     * @param string|null $path
     * @param null $default
     * @return array|mixed
     */
    public function get(string $path = null, $default = null)
    {
        return $path ? Arr::get($this->all(), $path, $default) : $this->all();
    }

    /**
     * @param string $path
     * @param $value
     * @return DynamicManager
     */
    public function update(string $path, $value)
    {
        return $this->set($path, $value);
    }

    /**
     * 保存动态字段
     *
     * @param array $values
     * @return $this
     */
    public function apply(array $values = [])
    {
        $this->model->{$this->field} = $values;
        $this->model->save();

        return $this;
    }

    /**
     * @param string|null $path
     * @return $this
     */
    public function delete(string $path = null)
    {
        if (!$path) {
            $values = [];
        } else {
            $values = $this->all();
            Arr::forget($values, $path);
        }

        $this->apply($values);

        return $this;
    }

    /**
     * @param string $path
     * @param $value
     * @return DynamicManager
     */
    public function set(string $path, $value)
    {
        $values = $this->all();

        Arr::set($values, $path, $value);

        return $this->apply($values);
    }

}