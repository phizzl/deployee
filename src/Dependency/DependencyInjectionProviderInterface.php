<?php


namespace Deployee\Dependency;


use Deployee\Kernel\DependencyProviderContainerInterface;

interface DependencyInjectionProviderInterface
{
    /**
     * @param DependencyProviderContainerInterface $container
     * @return mixed
     */
    public function injectDependencies(DependencyProviderContainerInterface $container);
}