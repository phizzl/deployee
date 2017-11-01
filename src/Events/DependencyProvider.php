<?php

namespace Deployee\Events;


use Deployee\Dependency\DependencyProviderInterface;
use Deployee\Events\Module;
use Deployee\Kernel\Locator;
use Symfony\Component\EventDispatcher\EventDispatcher;

class DependencyProvider implements DependencyProviderInterface
{
    /**
     * @param Locator $locator
     */
    public function defineDependencies(Locator $locator)
    {
        $locator
            ->Dependency()
            ->getFacade()
            ->setDependency(Module::EVENT_DISPATCHER_DEPENDENCY, function(){
                return new EventDispatcher();
            });
    }

}