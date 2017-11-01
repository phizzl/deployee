<?php

namespace Deployee\Plugins\RunDeploy;


use Deployee\Dependency\DependencyProviderInterface;
use Deployee\Kernel\Locator;

class DependencyProvider implements DependencyProviderInterface
{
    /**
     * @param Locator $locator
     */
    public function defineDependencies(Locator $locator)
    {
        $locator->Dependency()->defineDependency(Module::DISPATCHER_COLLECTION_DEPENDENCY, function() use($locator){
            return $locator->RunDeploy()->getFactory()->createDispatcherCollection();
        });

        $locator->Dependency()->defineDependency(Module::DISPATCHER_FINDER_DEPENDENCY, function() use($locator){
            return $locator->RunDeploy()->getFactory()->createDispatcherFinder();
        });
    }
}