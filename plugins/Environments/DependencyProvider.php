<?php

namespace Deployee\Plugins\Environments;


use Deployee\Dependency\DependencyProviderInterface;
use Deployee\Kernel\Locator;

class DependencyProvider implements DependencyProviderInterface
{
    /**
     * @param Locator $locator
     */
    public function defineDependencies(Locator $locator)
    {
        $locator->Dependency()->getFacade()->setDependency(Module::CURRENT_ENVIRONMENT_DEPENDENCY, function() use ($locator){
            return $locator->Environments()->getFactory()->createEnvironment('');
        });
    }
}