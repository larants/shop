<?php
/**
 * Created by PhpStorm.
 * User: jonathan
 * Date: 2020/5/8
 */
namespace App\DB\Filters;

use Leading\Lib\Eloquent\Filter;

/**
 * Class UserFilter
 * @package App\DB\Filters
 */
class UserFilter extends Filter
{

    /**
     * @param string $str
     */
    public function name($str)
    {
        $this->whereLike('name', $str);
    }

}