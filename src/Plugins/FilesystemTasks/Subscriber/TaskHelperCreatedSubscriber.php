<?php

namespace Phizzl\Deployee\Plugins\FilesystemTasks\Subscriber;


use Phizzl\Deployee\Plugins\Deploy\Events\TaskHelperCreatedEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class TaskHelperCreatedSubscriber implements EventSubscriberInterface
{
    /**
     * @return array
     */
    public static function getSubscribedEvents()
    {
        return [
            TaskHelperCreatedEvent::EVENT_NAME => 'onTaskHelperCreated'
        ];
    }

    /**
     * @param TaskHelperCreatedEvent $event
     */
    public function onTaskHelperCreated(TaskHelperCreatedEvent $event)
    {
        $taskHelper = $event->getTaskHelper();
    }
}