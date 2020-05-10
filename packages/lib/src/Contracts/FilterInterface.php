<?php
/**
 * Created by PhpStorm.
 * User: jonathan
 * Date: 2019-07-12
 */

namespace Leading\Lib\Contracts;


use Illuminate\Database\Eloquent\Builder;

/**
 * Interface FilterInterface
 * @package Leading\Lib\Contracts
 */
interface FilterInterface
{
    /**
     * @param Builder $builder
     * @param array $input
     * @return Builder
     */
    public function handle(Builder $builder, array $input = []): Builder;
}