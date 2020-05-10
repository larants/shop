<?php
/**
 * Created by PhpStorm.
 * User: jonathan
 * Date: 2020/3/3
 */

namespace Leading\Lib\Contracts;


/**
 * Interface RepositoryInterface
 * @package Leading\Lib\Contracts
 */
interface RepositoryInterface
{
    /**
     * @return mixed
     */
    public function newModel();

}