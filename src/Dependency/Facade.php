<?php


namespace Deployee\Dependency;


use Deployee\Kernel\Modules\AbstractFacade;

class Facade extends AbstractFacade
{
    /**
     * @param string $id
     * @return mixed
     */
    public function getDependency($id)
    {
        return $this->locator->Dependency()->getFactory()->createDependencyProviderContainer()->getDependency($id);
    }

    /**
     * @param string $id
     * @param mixed $value
     * @return mixed
     */
    public function setDependency($id, $value)
    {
        return $this->locator->Dependency()->getFactory()->createDependencyProviderContainer()->setDependency($id, $value);
    }

    /**
     * @param string $id
     * @param callable $callable
     */
    public function extendDependency($id, callable $callable)
    {
        $this->locator->Dependency()->getFactory()->createDependencyProviderContainer()->extendDependency($id, $callable);
    }
}