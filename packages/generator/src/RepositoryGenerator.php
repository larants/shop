<?php
/**
 * Created by PhpStorm.
 * User: jonathan
 * Date: 2019-02-10
 */

namespace Leading\Generator;

/**
 * Class RepositoryGenerator
 * @package Leading\Generator
 */
class RepositoryGenerator extends AbstractGenerator
{

    /**
     * @var string
     */
    protected $type = 'repository';

    /**
     * Get array replacements.
     *
     * @return array
     */
    public function getReplacements()
    {
        return array_merge(
            parent::getReplacements(),
            $this->getModelNamespace()
        );
    }

    /**
     * @return array
     */
    protected function getModelNamespace()
    {
        $generator = new ModelGenerator([
            'name' => $this->option('name')
        ]);

        return [
            'modelClassNamespace' => $generator->getClassNamespace(),
            'modelClassName' => $generator->getClassName()
        ];
    }
}