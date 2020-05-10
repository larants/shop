<?php
/**
 * Created by PhpStorm.
 * User: jonathan
 * Date: 2019-02-10
 */

namespace Leading\Generator;

use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Arr;
use Illuminate\Support\Composer;
use Illuminate\Support\Str;
use Leading\Generator\Exceptions\FileAlreadyExistsException;
use Leading\Generator\Parsers\SchemaParser;
use Leading\Generator\Parsers\StubParser;

/**
 * Class AbstractGenerator
 * @package Leading\Generator
 * @property boolean $force
 */
abstract class AbstractGenerator
{

    /**
     * The filesystem instance.
     *
     * @var Filesystem
     */
    protected $filesystem;

    /**
     * @var SchemaParser
     */
    protected $schemaParser;

    /**
     * @var Composer
     */
    protected $composer;

    /**
     * The array of options.
     *
     * @var array
     */
    protected $options;

    /**
     * The type of class.
     *
     * @var string
     */
    protected $type;

    /**
     * @var
     */
    protected $pName;

    /**
     * Create new instance of this class.
     *
     * AbstractGenerator constructor.
     * @param array $options
     */
    public function __construct(array $options = [])
    {
        $this->options = $options;
        $this->filesystem = new Filesystem();
        $this->schemaParser = app(SchemaParser::class);
        $this->composer = app(Composer::class);
    }


    /**
     * Run the generators.
     *
     * @return int
     * @throws FileAlreadyExistsException
     */
    public function run()
    {
        $path = $this->getClassFilePath();
        if ($this->filesystem->exists($path) && !$this->force) {
            throw new FileAlreadyExistsException($path);
        }
        if (!$this->filesystem->isDirectory($dir = dirname($path))) {
            $this->filesystem->makeDirectory($dir, 0777, true, true);
        }

        $this->filesystem->put($path, $this->getStubContents());

        return true;
    }

    /**
     * Get stub template for generated file.
     *
     * @return string
     */
    public function getStubContents()
    {
        $stubPath = __DIR__ . '/Stubs/' . $this->type . '.stub';

        return (new StubParser($stubPath, $this->getReplacements()))->getContents();
    }

    /**
     * Get template replacements.
     *
     * @return array
     */
    public function getReplacements()
    {
        return [
            'classNamespace' => $this->getClassNamespace(),
            'className' => $this->getClassName(),
            'singularName' => $this->getSingularName(),
            'pluralName' => $this->getPluralName()
        ];
    }

    /**
     * Get destination path for generated file.
     *
     * @return string
     */
    public function getClassFilePath()
    {
        $generatorPath = $this->getGeneratorPath($this->type, true);

        return app()->path() . '/' . $generatorPath . '/' . $this->getClassName() . '.php';
    }

    /**
     * 首字母大写（驼峰（单数）） test_users -- TestUser
     *
     * @return string
     */
    public function getName()
    {
        if (!$this->pName) {
            $name = $this->option('name');
            if (Str::contains($name, '\\')) {
                $name = str_replace('\\', '/', $name);
            }
            // 暂时取最后
            $names = explode('/', $name);
            $name = Arr::last($names);

            $this->pName = Str::studly(Str::singular($name));
        }

        return $this->pName;
    }

    /**
     * 单数变量
     *
     * @return string
     */
    public function getSingularName()
    {
        return lcfirst($this->getName());
    }

    /**
     * 复数变量
     *
     * @return string
     */
    public function getPluralName()
    {
        return Str::plural($this->getSingularName());
    }

    /**
     * hello/test_users -- TestUserController
     *
     * @return string
     */
    public function getClassName()
    {
        $type = $this->type == 'model' ? '' : $this->type;

        return $this->getName() . ucfirst($type);
    }

    /**
     * hello/test_users -- App\\Models\\Hello\\TestUsers
     *
     * @return mixed
     */
    public function getClassNamespace()
    {
        $classNamespace = $this->getAppNamespace() . $this->getGeneratorPath($this->type);

        return rtrim(str_replace(["\\", '/'], '\\', $classNamespace), '\\');
    }

    /**
     * Get the application namespace.
     *
     * @return string
     */
    protected function getAppNamespace()
    {
        return app()->getNamespace();
    }

    /**
     * @param string $type
     * @param bool $directoryPath
     * @return mixed
     */
    public function getGeneratorPath($type, $directoryPath = false)
    {
        $conn = $this->option('connection', 'default');
        switch ($type) {
            case 'model':
                $path = config("generator.{$conn}.model", 'DB\Models');
                break;
            case 'filter':
                $path = config('generator.default.filter', 'DB\Filters');
                break;
            case 'repository':
                $path = config('generator.default.repository', 'Repositories');
                break;
            case 'request':
                $path = config('generator.default.request', 'Http\Api\Requests');
                break;
            case 'controller':
                $path = config('generator.default.controller', 'Http\Api\Controllers');
                break;
            default:
                $path = '';
        }

        if ($directoryPath) {
            $path = str_replace('\\', '/', $path);
        } else {
            $path = str_replace('/', '\\', $path);
        }

        return $path;
    }

    /**
     * @return array
     */
    public function getOptions()
    {
        return $this->options;
    }

    /**
     * Determinate whether the given key exist in options array.
     *
     * @param string $key
     *
     * @return boolean
     */
    public function hasOption($key)
    {
        return array_key_exists($key, $this->options);
    }

    /**
     * Get value from options by given key.
     *
     * @param string $key
     * @param string|null $default
     *
     * @return string
     */
    public function getOption($key, $default = null)
    {
        if (!$this->hasOption($key)) {
            return $default;
        }

        return $this->options[$key] ?: $default;
    }

    /**
     * Helper method for "getOption".
     *
     * @param string $key
     * @param string|null $default
     *
     * @return string
     */
    public function option($key, $default = null)
    {
        return $this->getOption($key, $default);
    }

    /**
     * Handle call to __get method.
     *
     * @param string $key
     *
     * @return string|mixed
     */
    public function __get($key)
    {
        if (property_exists($this, $key)) {
            return $this->{$key};
        }

        return $this->option($key);
    }
}