<?php
/**
 * Created by PhpStorm.
 * User: jonathan
 * Date: 2018-12-12
 */

namespace Leading\Lib\Services;

use App\Models\User;
use Closure;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Support\Facades\DB;

/**
 * Class LibService
 * @property User $user
 * @package Leading\Lib\Services
 */
class LibService
{
    use DispatchesJobs;

    /**
     * db begin transaction
     */
    public function beginTransaction()
    {
        DB::beginTransaction();
    }

    /**
     * db rollback
     */
    public function rollback()
    {
        DB::rollBack();
    }

    /**
     * db commit
     */
    public function commit()
    {
        DB::commit();
    }

    /**
     * @param Closure $transaction
     * @return mixed
     */
    public function transaction(Closure $transaction)
    {
        return DB::transaction($transaction);
    }

    /**
     * @return User|mixed
     */
    public function user()
    {
        return auth()->user();
    }

    /**
     * @param $name
     * @return User|mixed|null
     */
    public function __get($name)
    {
        if ($name == 'user') {
            return $this->user();
        }

        return null;
    }
}