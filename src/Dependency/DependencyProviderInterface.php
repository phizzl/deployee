<?php

namespace Deployee\Dependency;

use Deployee\Kernel\Locator;

interface DependencyProviderInterface
{
    /**
     * @param Locator $locator
     */
    public function defineDependencies(Locator $locator);
}