<?php
/**
 * Created by PhpStorm.
 * User: jonathan
 * Date: 2019-07-12
 */

namespace Leading\Lib\Eloquent;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model as LaravelModel;
use Illuminate\Support\Facades\Date;
use Leading\Lib\Eloquent\Traits\Filterable;
use Leading\Lib\Eloquent\Traits\HasUuid;


/**
 * Class Model
 * @package Leading\Lib\Eloquent
 * @method Builder whereLike(string $column, $value)
 * @method Builder before(string $field, Carbon $carbon)
 * @method Builder after(string $field, Carbon $carbon)
 * @mixin Builder
 */
class Model extends LaravelModel
{
    use Filterable, HasUuid;

    /**
     * 如果要使用，需要指定类名
     *
     * @var string
     */
    protected $filterClass = Filter::class;

    /**
     * @param Builder $query
     * @param $column
     * @param $value
     * @return Builder
     */
    public function scopeWhereLike(Builder $query, $column, $value): Builder
    {
        return $query->where($column, 'LIKE', "%$value%");
    }


    /**
     * @param Builder $query
     * @param string $field
     * @param Carbon $carbon
     * @return Builder
     */
    public function scopeBefore(Builder $query, string $field, Carbon $carbon): Builder
    {
        return $query->where($field, '<=', $carbon);
    }

    /**
     * @param Builder $query
     * @param string $field
     * @param Carbon $carbon
     * @return Builder
     */
    public function scopeAfter(Builder $query, string $field, Carbon $carbon): Builder
    {
        return $query->where($field, '>=', $carbon);
    }


    /**
     * 获取创建时间
     *
     * @param string $value
     * @return string
     */
    public function getCreatedAtAttribute($value)
    {
        return Date::parse($value)->format('Y-m-d H:i:s');
    }

    /**
     * 获取更新时间
     *
     * @param string $value
     * @return string
     */
    public function getUpdatedAtAttribute($value)
    {
        return Date::parse($value)->format('Y-m-d H:i:s');
    }

}