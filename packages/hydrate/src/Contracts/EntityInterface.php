<?php
/**
 * Created by PhpStorm.
 * User: jonathan
 * Date: 2019-05-21
 */

namespace Leading\Hydrate\Contracts;

use Illuminate\Support\Collection;

/**
 * Interface EntityInterface
 * @package Leading\Hydrate\Contracts
 */
interface EntityInterface
{

    /**
     * @param array $data
     * @return static
     */
    public static function instance(array $data);

    /**
     * @param array $data
     * @return static
     */
    public function toObject(array $data);

    /**
     * @param bool $filter
     * @return array
     */
    public function toArray($filter = false);

    /**
     * @return Collection
     */
    public function toCollection();

    /**
     * @param string|array $keys
     * @param bool $filter
     * @return array
     */
    public function except($keys, $filter = false);

    /**
     * @param string|array $keys
     * @param bool $filter
     * @return array
     */
    public function only($keys, $filter = false);

    /**
     * @param null $key
     * @return array|string
     */
    public function getOriginal($key = null);

}