<?php

namespace App\Console\Commands;

use App\ZenCart\Product;
use Illuminate\Console\Command;

/**
 * Class ProductMigration
 * @package App\Console\Commands
 */
class ProductMigration extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'product:migration';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '产品迁移';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @param Product $product
     */
    public function handle(Product $product)
    {
        $product->with([
            'description',
            'attributes.option',
            'attributes.optionValue',
            'galleries',
            'categories.description'
        ])->each(function (Product $product) {
            dd($product->toArray());
        });
    }
}
