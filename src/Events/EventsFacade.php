<?php

namespace Deployee\Events;


use Deployee\Kernel\LocatorAwareInterface;
use Deployee\Kernel\Modules\AbstractFacade;
use Symfony\Component\EventDispatcher\Event;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class EventsFacade extends AbstractFacade
{
    /**
     * @var EventDispatcher
     */
    private $dispatcher;

    /**
     * @param EventSubscriberInterface $subscriber
     */
    public function addSubscriber(EventSubscriberInterface $subscriber)
    {
        $this->getEventDispatcher()->addSubscriber($subscriber);
    }

    /**
     * @param $name
     * @param Event $event
     * @return Event
     */
    public function dispatchEvent($name, Event $event)
    {
        if($event instanceof LocatorAwareInterface){
            $event->setLocator($this->locator);
        }

        return $this->getEventDispatcher()->dispatch($name, $event);
    }

    /**
     * @return EventDispatcher
     */
    private function getEventDispatcher()
    {
        return $this->dispatcher === null
            ? $this->dispatcher = $this->locator->Events()->getFactory()->createEventDispatcher()
            : $this->dispatcher;
    }
}