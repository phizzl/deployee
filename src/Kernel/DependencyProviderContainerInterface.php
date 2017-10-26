<?php

namespace Deployee\Kernel;


interface DependencyProviderContainerInterface
{
    /**
     * @param string $id
     * @return mixed
     */
    public function getDependency($id);
}