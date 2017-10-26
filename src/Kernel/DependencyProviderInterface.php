<?php

namespace Deployee\Kernel;


interface DependencyProviderInterface
{
    /**
     * @param string $id
     * @return mixed
     */
    public function getDependency($id);
}