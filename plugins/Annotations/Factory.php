<?php

namespace Deployee\Plugins\Annotations;


use Deployee\Kernel\Modules\AbstractFactory;
use phpDocumentor\Reflection\DocBlockFactory;

class Factory extends AbstractFactory
{
    /**
     * @param object $object
     * @return \phpDocumentor\Reflection\DocBlock
     */
    public function createInstanceDocBlock($class)
    {
        if(!is_object($class)
            && !class_exists($class)){
            throw new \InvalidArgumentException("Expected object or class name. Invalid argument given \n" . var_export($class, true));
        }

        return $this->createDocBlockFactory()->create(new \ReflectionClass($class));
    }

    /**
     * @return DocBlockFactory
     */
    public function createDocBlockFactory()
    {
        return DocBlockFactory::createInstance();
    }
}