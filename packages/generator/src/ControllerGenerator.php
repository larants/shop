<?php
/**
 * Created by PhpStorm.
 * User: jonathan
 * Date: 2019-02-10
 */

namespace Leading\Generator;

/**
 * Class ControllerGenerator
 * @package Leading\Generator
 */
class ControllerGenerator extends AbstractGenerator
{
    /**
     * @var string
     */
    protected $type = 'controller';

    /**
     * Get array replacements.
     *
     * @return array
     */
    public function getReplacements()
    {
        return array_merge(
            parent::getReplacements(),
            $this->getRequestNamespace(),
            $this->getRepositoryNamespace()
        );
    }

    /**
     * Gets validator full class name
     *
     * @return array
     */
    public function getRequestNamespace()
    {

        $generator = new RequestGenerator([
            'name' => $this->name,
        ]);

        return [
            'requestClassNamespace' => $generator->getClassNamespace(),
            'requestClassName' => $generator->getClassName()
        ];
    }

    /**
     * Gets repository full class name
     *
     * @return array
     */
    public function getRepositoryNamespace()
    {
        $generator = new RepositoryGenerator([
            'name' => $this->name,
        ]);

        return [
            'repositoryClassNamespace' => $generator->getClassNamespace(),
            'repositoryClassName' => $generator->getClassName()
        ];
    }
}