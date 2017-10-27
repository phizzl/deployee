<?php

namespace Deployee\Events;


use Deployee\Kernel\Modules\AbstractFactory;
use Symfony\Component\EventDispatcher\EventDispatcher;

class EventsFactory extends AbstractFactory
{
    /**
     * @return EventDispatcher
     */
    public function createEventDispatcher()
    {
        return $this->locator->Dependency()->getFacade()->getDependency(EventsModule::EVENT_DISPATCHER_DEPENDENCY);
    }
}