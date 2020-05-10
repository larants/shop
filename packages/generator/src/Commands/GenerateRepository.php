<?php
/**
 * Created by PhpStorm.
 * User: jonathan
 * Date: 2019-02-10
 */

namespace Leading\Generator\Commands;

use Illuminate\Console\Command;
use Leading\Generator\Exceptions\FileAlreadyExistsException;
use Leading\Generator\RepositoryGenerator;

/**
 * Class GenerateRepository
 * @package Leading\Generator\Commands
 */
class GenerateRepository extends Command
{
    /**
     * The name of the console command.
     *
     * @var string
     */
    protected $signature = 'generate:repository
                            {name : The name of class being generated.}
                            {--c|connection= : (optional) database connection.}
                            {--f|force= : (optional) Force the creation if file already exists.}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '生成Repository文件';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->call('generate:model', [
            'name' => $this->argument('name'),
            '--force' => $this->option('force')
        ]);

        try {
            (new RepositoryGenerator([
                'name' => $this->argument('name'),
                'force' => $this->option('force')
            ]))->run();
            $this->info('Repository generated successfully!');
        } catch (FileAlreadyExistsException $e) {
            $this->error('Repository already exists!');
        }
    }
}