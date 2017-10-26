<?php


namespace Deployee\Dependency;


use Deployee\Kernel\Locator;

interface DependencyInjectionProviderInterface
{
    /**
     * @param Locator $locator
     */
    public function injectDependencies(Locator $locator);
}