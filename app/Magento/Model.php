<?php
/**
 * Created by PhpStorm.
 * User: jonathan
 * Date: 2020/5/6
 */

namespace App\Magento;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model as EloquentModel;

/**
 * Class Model
 * @package App\Magento
 * @mixin Builder
 */
class Model extends EloquentModel
{
    /**
     * @var string
     */
    protected $connection = 'magento';

}