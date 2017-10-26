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
        return new EventDispatcher();
    }
}