<?php

namespace Deployee\Events\Dependency;


use Deployee\Dependency\DependencyProviderInterface;
use Deployee\Events\EventsModule;
use Deployee\Kernel\Locator;
use Symfony\Component\EventDispatcher\EventDispatcher;

class EventsDependencyProvider implements DependencyProviderInterface
{
    /**
     * @param Locator $locator
     */
    public function defineDependencies(Locator $locator)
    {
        $locator
            ->Dependency()
            ->getFacade()
            ->setDependency(EventsModule::EVENT_DISPATCHER_DEPENDENCY, function(){
                return new EventDispatcher();
            });
    }

}