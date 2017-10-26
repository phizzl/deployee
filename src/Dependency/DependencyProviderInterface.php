<?php

namespace Deployee\Dependency;

use Deployee\Kernel\DependencyProviderContainerInterface;

interface DependencyProviderInterface
{
    /**
     * @param DependencyProviderContainerInterface $container
     * @return mixed
     */
    public function defineDependencies(DependencyProviderContainerInterface $container);
}