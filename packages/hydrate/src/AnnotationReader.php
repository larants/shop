<?php

namespace Leading\Hydrate;

use Doctrine\Common\Annotations\AnnotationReader as DoctrineAnnotationReader;
use Doctrine\Common\Annotations\AnnotationRegistry;

/**
 * Class AnnotationReader
 * @package Larant\Hydrate
 */
class AnnotationReader
{
    /**
     * @return DoctrineAnnotationReader
     */
    public static function instance()
    {
        AnnotationRegistry::registerFile(__DIR__ . '/MapAnnotation.php');

        return new DoctrineAnnotationReader();
    }
}