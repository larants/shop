<?php
/**
 * Created by PhpStorm.
 * User: jonathan
 * Date: 2019-02-10
 */

namespace Leading\Generator\Commands;

use Illuminate\Console\Command;
use Leading\Generator\Exceptions\FileAlreadyExistsException;
use Leading\Generator\FilterGenerator;
use Leading\Generator\ModelGenerator;

/**
 * Class GenerateModel
 * @package Leading\Generator\Commands
 */
class GenerateModel extends Command
{
    /**
     * The name of the console command.
     *
     * @var string
     */
    protected $signature = 'generate:model
                            {name : The name of class being generated.}
                            {--c|connection= : (optional) database connection.}
                            {--f|force : (optional) Force the creation if file already exists.}
                            {--with-filter : (optional) skip create filter class.}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '生成Model文件';

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
     * Execute the console command.
     */
    public function handle()
    {
        try {
            (new ModelGenerator([
                'name' => $this->argument('name'),
                'connection' => $this->option('connection'),
                'force' => $this->option('force')
            ]))->run();

            $this->info('Model generated successfully!');
            if ($this->option('with-filter')) {
                (new FilterGenerator([
                    'name' => $this->argument('name'),
                    'force' => $this->option('force')
                ]))->run();
            }
        } catch (FileAlreadyExistsException $e) {
            $this->error('Model already exists!');
        }
    }
}