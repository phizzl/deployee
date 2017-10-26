<?php

namespace Deployee\Kernel;

class DependencyProviderContainer extends \Pimple\Container implements DependencyProviderContainerInterface
{
    /**
     * @param string $id
     * @return mixed
     */
    public function getDependency($id)
    {
        return $this[$id];
    }

    /**
     * @param string $id
     * @param mixed $value
     */
    public function setDependency($id, $value)
    {
        $this[$id] = $value;
    }

    /**
     * @param string $id
     * @param callable $callable
     */
    public function extendDependency($id, callable $callable)
    {
        $this->extend($id, $callable);
    }
}