<?php
/**
 * Created by PhpStorm.
 * User: jonathan
 * Date: 2018/11/15
 */

namespace Leading\Hydrate;

use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Leading\Hydrate\Contracts\EntityInterface;


/**
 * Class Entity
 * @package Leading\Hydrate
 */
class Entity implements EntityInterface
{

    /**
     * @var array
     */
    protected $original = [];


    /**
     * @param array $data
     * @return EntityInterface|static
     */
    public static function instance(array $data)
    {
        return (new static())->toObject($data);
    }

    /**
     * array to this object
     *
     * @param array $data
     * @return EntityInterface|static
     */
    public function toObject(array $data)
    {
        $this->original = $data;

        return $this->getReflection()->hydrate($data, $this);
    }


    /**
     * @param bool $filter
     * @return array
     */
    public function toArray($filter = false)
    {
        $result = $this->getReflection()->extract($this);

        return $filter ? array_filter($result) : $result;
    }

    /**
     * @param bool $filter
     * @return Collection
     */
    public function toCollection($filter = false)
    {
        return collect($this->toArray($filter));
    }

    /**
     * @param array|string $keys
     * @param bool $filter
     * @return array
     */
    public function except($keys, $filter = false)
    {
        return Arr::except($this->toArray($filter), $keys);
    }


    /**
     * @param array|string $keys
     * @param bool $filter
     * @return array
     */
    public function only($keys, $filter = false)
    {
        return Arr::only($this->toArray($filter), $keys);
    }


    /**
     * @param null $key
     * @return array|string
     */
    public function getOriginal($key = null)
    {
        if ($key) {
            return Arr::get($this->original, $key);
        }

        return $this->original;
    }

    /**
     * @return Reflection
     */
    protected function getReflection()
    {
        return app(Reflection::class);
    }
}