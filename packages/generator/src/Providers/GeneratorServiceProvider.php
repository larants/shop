<?php
/**
 * Created by PhpStorm.
 * User: jonathan
 * Date: 2019/9/29
 */

namespace Leading\Generator\Providers;

use Illuminate\Support\ServiceProvider;
use Leading\Generator\Commands\GenerateController;
use Leading\Generator\Commands\GenerateCriteriaCommand;
use Leading\Generator\Commands\GenerateEntity;
use Leading\Generator\Commands\GenerateModel;
use Leading\Generator\Commands\GenerateRepository;

/**
 * Class GeneratorsServiceProvider
 * @package Larant\Generator
 */
class GeneratorServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__ . '/../../config/generator.php' => config_path('generator.php'),
        ]);
    }

    public function register()
    {
        $this->registerConfig();

        $this->commands(GenerateModel::class);
        $this->commands(GenerateRepository::class);
        $this->commands(GenerateController::class);
        $this->commands(GenerateEntity::class);
    }

    /**
     * Register the configuration.
     *
     * @return void
     */
    protected function registerConfig()
    {
        $this->mergeConfigFrom(realpath(__DIR__ . '/../../config/generator.php'), 'generator');
    }
}