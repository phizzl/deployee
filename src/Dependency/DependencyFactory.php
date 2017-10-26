<?php


namespace Deployee\Dependency;


use Deployee\Kernel\Modules\AbstractFactory;

class DependencyFactory extends AbstractFactory
{
    /**
     * @return \Deployee\Kernel\DependencyProviderContainerInterface
     */
    public function createDependencyProviderContainer()
    {
        return $this->locator->getDependencyProviderContainer();
    }
}