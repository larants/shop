<?php
/**
 * Created by PhpStorm.
 * User: jonathan
 * Date: 2020/3/2
 */

namespace Leading\Lib\Eloquent\Traits;


use Exception;
use Illuminate\Database\Eloquent\Builder;
use Leading\Lib\Contracts\FilterInterface;

/**
 * Trait Filterable
 * @package Leading\Lib\Eloquent\Traits
 * @method static Builder filter(array $input = [], string $filterClass = null)
 */
trait Filterable
{
    /**
     * Creates local scope to run the filter.
     *
     * @param Builder $query
     * @param array $input
     * @param string|null $filterClass
     * @return Builder
     */
    public function scopeFilter(Builder $query, array $input = [], string $filterClass = null)
    {
        $filter = $this->newModelFilter($filterClass);
        if ($filter && $filter instanceof FilterInterface) {
            return $filter->handle($query, $input);
        }

        return $query;
    }


    /**
     * @param string|null $filterClass
     * @return FilterInterface|false
     */
    protected function newModelFilter(string $filterClass = null)
    {
        try {
            if ($filterClass) {
                return app($filterClass);
            } elseif ($this->filterClass) {
                return app($this->filterClass);
            }
        } catch (Exception $e) {

        }

        return false;
    }
}