<?php
/**
 * Created by PhpStorm.
 * User: jonathan
 * Date: 2019-02-10
 */

namespace Leading\Generator\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Collection;
use Leading\Generator\Exceptions\FileAlreadyExistsException;
use Leading\Generator\ControllerGenerator;
use Leading\Generator\RequestGenerator;

/**
 * Class GenerateController
 * @package Leading\Generator\Commands
 */
class GenerateController extends Command
{
    /**
     * The name of the console command.
     *
     * @var string
     */
    protected $signature = 'generate:controller
                            {name : The name of class being generated.}
                            {--c|connection= : (optional) database connection.}
                            {--f|force= : (optional) Force the creation if file already exists.}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '生成Controller文件';

    /**
     * @var Collection
     */
    protected $generators;

    /**
     * GenerateControllerCommand constructor.
     */
    public function __construct()
    {
        parent::__construct();

        $this->generators = collect();
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // generate repository,model,filter
        $this->call('generate:repository', [
            'name' => $this->argument('name'),
            '--connection' => $this->option('connection'),
            '--force' => $this->option('force')
        ]);
        // generate form request
        try {
            (new RequestGenerator([
                'name' => $this->argument('name'),
                'force' => $this->option('force')
            ]))->run();

            $this->info('Request generated successfully!');
        } catch (FileAlreadyExistsException $e) {
            $this->error('Request already exists!');
        }
        // generate controller
        try {
            (new ControllerGenerator([
                'name' => $this->argument('name'),
                'force' => $this->option('force'),
            ]))->run();
            $this->info('Controller generated successfully!');
        } catch (FileAlreadyExistsException $e) {
            $this->error('Controller already exists!');
        }
    }
}