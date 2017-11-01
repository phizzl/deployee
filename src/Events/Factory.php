<?php

namespace Deployee\Events;


use Deployee\Kernel\Modules\AbstractFactory;
use Symfony\Component\EventDispatcher\EventDispatcher;

class Factory extends AbstractFactory
{
    /**
     * @return EventDispatcher
     */
    public function createEventDispatcher()
    {
        return $this->locator->Dependency()->getFacade()->getDependency(Module::EVENT_DISPATCHER_DEPENDENCY);
    }
}