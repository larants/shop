<?php
/**
 * Created by PhpStorm.
 * User: jonathan
 * Date: 2018-12-11
 */

namespace Leading\Lib\Eloquent;

use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Support\Traits\ForwardsCalls;
use Illuminate\Database\Eloquent\Builder;
use Leading\Lib\Contracts\FilterInterface;
use Leading\Lib\Exceptions\QueryException;

/**
 * Class ModelFilter
 * @package Leading\Lib\Eloquent
 * @mixin Model
 */
class Filter implements FilterInterface
{
    use ForwardsCalls;

    /**
     * @var Builder
     */
    protected $builder;

    /**
     * @var array
     */
    protected $input = [];

    /**
     * @param Builder $builder
     * @param array $input
     * @return Builder
     */
    public function handle(Builder $builder, array $input = []): Builder
    {
        $this->builder = $builder;
        $this->input = $input;
        // with 关系
        if ($with = Arr::get($input, 'with')) {
            $this->handleWith($with);
        }
        // withCount 关系
        if ($withCount = Arr::get($input, 'withCount')) {
            $this->handleWithCount($withCount);
        }
        // 数据过滤
        if ($filters = Arr::get($input, 'filters')) {
            $this->handleFilters($filters);
        }
        // 排序
        if ($sorter = Arr::get($input, 'sorter')) {
            $this->handleSorter($sorter);
        }

        return $this->builder;
    }

    /**
     * @param $relations
     * @return void
     */
    public function handleWith(string $relations)
    {
        $relations = $this->handleRelations($relations);

        $this->with($relations);
    }

    /**
     * @param $relations
     * @return void
     */
    public function handleWithCount(string $relations)
    {
        $relations = $this->handleRelations($relations);

        $this->withCount($relations);
    }


    /**
     * @param $sorter
     * @return void
     */
    public function handleSorter($sorter)
    {
        [$column, $direction] = array_pad(explode(':', $sorter), 2, 'asc');
        if ($direction != 'undefined') {
            $direction = str_replace('end', '', $direction);
            $this->orderBy($column, $direction);
        }

    }

    /**
     * @param array $filters
     * @return void
     */
    public function handleFilters(array $filters): void
    {
        foreach ($filters as $key => $val) {
            $method = $this->keyMethod($key);
            if ($this->isCallable($method)) {
                $this->{$method}($val);
            }
        }
    }

    /**
     * @param $column
     * @param $value
     * @return Filter
     */
    public function whereLike($column, $value)
    {
        // 为了方便链式操作
        return $this->where($column, 'LIKE', "%{$value}%");
    }

    /**
     * @param $column
     * @param $value
     * @return Filter
     */
    public function orWhereLike($column, $value)
    {
        return $this->orWhere($column, 'LIKE', "%{$value}%");
    }


    /**
     * @param $name
     * @param $arguments
     * @return $this
     * @throws QueryException
     */
    public function __call($name, $arguments)
    {
        $result = $this->forwardCallTo($this->builder, $name, $arguments);
        if ($result instanceof Builder) {
            return $this;
        }

        throw new QueryException("构造器函数({$name})返回数据类型错误。");
    }


    /**
     * @param string $relations
     * @return array
     */
    public function handleRelations(string $relations)
    {
        $relations = explode(',', $relations);

        return collect($relations)->map(function ($relation) {
            return Str::camel($relation);
        })->toArray();
    }

    /**
     * 转为驼峰模式
     *
     * @param $key
     * @return string
     */
    protected function keyMethod($key)
    {
        // 替换id
        $key = preg_replace('/^(.*)_id$/', '$1', $key);

        return Str::camel(str_replace('.', '_', $key));
    }


    /**
     * 是否存在该函数
     *
     * @param $method
     * @return bool
     */
    protected function isCallable($method)
    {
        return method_exists($this, $method);
    }

}