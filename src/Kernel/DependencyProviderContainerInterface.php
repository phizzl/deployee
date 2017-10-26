<?php

namespace Deployee\Kernel;


interface DependencyProviderContainerInterface
{
    /**
     * @param string $id
     * @return mixed
     */
    public function getDependency($id);

    /**
     * @param string $id
     * @param mixed $value
     * @return mixed
     */
    public function setDependency($id, $value);

    /**
     * @param string $id
     * @param callable $callable
     */
    public function extendDependency($id, callable $callable);
}