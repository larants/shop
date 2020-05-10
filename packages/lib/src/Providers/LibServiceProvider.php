<?php
/**
 * Created by PhpStorm.
 * User: jonathan
 * Date: 2018-12-11
 */

namespace Leading\Lib\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

/**
 * Class LibServiceProvider
 * @package Leading\Lib\Providers
 */
class LibServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();
        $this->publishes([
            __DIR__ . '/../../config/lib.php' => config_path('lib.php'),
        ]);
    }

    public function register()
    {
        $this->registerConfig();
    }

    /**
     * Register the configuration.
     *
     * @return void
     */
    protected function registerConfig()
    {
        $this->mergeConfigFrom(realpath(__DIR__ . '/../../config/lib.php'), 'lib');
    }

    /**
     * @var array
     */
    protected $listen = [];
}