<?php

namespace Deployee\ClassLoader;


use Composer\Autoload\ClassLoader;
use Deployee\Kernel\Modules\AbstractFactory;

class ClassLoaderFactory extends AbstractFactory
{
    /**
     * @return ClassLoader
     */
    public function createClassLoader()
    {
        return $this->locator->getDependencyProviderContainer()->getDependency(ClassLoaderModule::CLASS_LOADER_CONTAINER_ID);
    }
}