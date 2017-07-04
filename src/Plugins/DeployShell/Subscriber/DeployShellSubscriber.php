<?php

namespace Phizzl\Deployee\Plugins\DeployShell\Subscriber;


use Phizzl\Deployee\Events\TaskDispatcherCollectionInitializedEvent;
use Phizzl\Deployee\Plugins\Deploy\Events\TaskHelperCreatedEvent;
use Phizzl\Deployee\Plugins\DeployShell\Dispatcher\ShellTaskDispatcher;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class DeployShellSubscriber implements EventSubscriberInterface
{
    /**
     * @return array
     */
    public static function getSubscribedEvents()
    {
        return [
            TaskHelperCreatedEvent::EVENT_NAME => 'onTaskHelperCreated',
            TaskDispatcherCollectionInitializedEvent::EVENT_NAME => 'onTaskDispatcherCollectionInitialized'
        ];
    }

    /**
     * @param TaskHelperCreatedEvent $event
     */
    public function onTaskHelperCreated(TaskHelperCreatedEvent $event)
    {
        $taskHelper = $event->getTaskHelper();
        $taskHelper->registerTask('Phizzl\Deployee\Plugins\DeployShell\Tasks\ShellTask', 'shell');
    }

    /**
     * @param TaskDispatcherCollectionInitializedEvent $event
     */
    public function onTaskDispatcherCollectionInitialized(TaskDispatcherCollectionInitializedEvent $event)
    {
        $collection = $event->getTaskDispatcherCollection();
        $collection->registerDispatcher(new ShellTaskDispatcher($event->getContainer()));
    }
}