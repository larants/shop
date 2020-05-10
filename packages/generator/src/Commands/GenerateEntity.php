<?php
/**
 * Created by PhpStorm.
 * User: jonathan
 * Date: 2019-07-23
 */

namespace Leading\Generator\Commands;

use Illuminate\Console\Command;
use Leading\Generator\EntityGenerator;
use Leading\Generator\Exceptions\FileAlreadyExistsException;

/**
 * Class GenerateEntity
 * @package Leading\Generator\Commands
 */
class GenerateEntity extends Command
{

    /**
     * The name of the console command.
     *
     * @var string
     */
    protected $signature = 'generate:entity
                            {name : The name of entity being generated.}
                            {--f|force= : (optional) Force the creation if file already exists.}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '生成Entity文件';

    /**
     * @var EntityGenerator
     */
    protected $entityGenerator;


    /**
     * CreateEntityCommand constructor.
     * @param EntityGenerator $entityGenerator
     */
    public function __construct(EntityGenerator $entityGenerator)
    {
        parent::__construct();

        $this->entityGenerator = $entityGenerator;
    }


    /**
     * @throws FileAlreadyExistsException
     */
    public function handle()
    {
        $options = [
            'name' => $this->argument('name'),
            'force' => $this->option('force')
        ];
        $this->entityGenerator->setOptions($options);
        $this->entityGenerator->run();
    }
}