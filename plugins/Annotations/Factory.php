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
    public function createInstanceDocBlock($object)
    {
        if(!is_object($object)){
            throw new \InvalidArgumentException("Expected object. Invalid argument given \n" . var_export($object, true));
        }

        return $this->createDocBlockFactory()->create(new \ReflectionClass($object));
    }

    /**
     * @return DocBlockFactory
     */
    public function createDocBlockFactory()
    {
        return DocBlockFactory::createInstance();
    }
}