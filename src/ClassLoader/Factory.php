<?php

namespace Deployee\ClassLoader;


use Composer\Autoload\ClassLoader;
use Deployee\Kernel\Modules\AbstractFactory;

class Factory extends AbstractFactory
{
    /**
     * @return ClassLoader
     */
    public function createClassLoader()
    {
        return $this->locator->getDependencyProviderContainer()->getDependency(Module::CLASS_LOADER_CONTAINER_ID);
    }
}