<?php


namespace Deployee\Dependency;


use Deployee\Kernel\Modules\AbstractFacade;

class DependencyFacade extends AbstractFacade
{
    /**
     * @var DependencyFactory
     */
    protected $factory;

    /**
     * @param string $id
     * @return mixed
     */
    public function getDependency($id)
    {
        return $this->factory->createDependencyProviderContainer()->getDependency($id);
    }

    /**
     * @param string $id
     * @param mixed $value
     * @return mixed
     */
    public function setDependency($id, $value)
    {
        return $this->factory->createDependencyProviderContainer()->setDependency($id, $value);
    }

    /**
     * @param string $id
     * @param callable $callable
     */
    public function extendDependency($id, callable $callable)
    {
        $this->factory->createDependencyProviderContainer()->extendDependency($id, $callable);
    }
}