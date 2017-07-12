<?php

namespace Deployee\Plugins\DeployFilesystem\Subscriber;


use Deployee\Events\TaskDispatcherCollectionInitializedEvent;
use Deployee\Plugins\Deploy\Events\TaskHelperCreatedEvent;
use Deployee\Plugins\DeployFilesystem\Dispatcher\FilesystemTaskDispatcher;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class DeployFilesystemSubscriber implements EventSubscriberInterface
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
        $taskHelper->registerTask('Deployee\Plugins\DeployFilesystem\Tasks\DirectoryTask', 'directory');
        $taskHelper->registerTask('Deployee\Plugins\DeployFilesystem\Tasks\FileTask', 'file');
        $taskHelper->registerTask('Deployee\Plugins\DeployFilesystem\Tasks\PermissionsTask', 'permission');
    }

    /**
     * @param TaskDispatcherCollectionInitializedEvent $event
     */
    public function onTaskDispatcherCollectionInitialized(TaskDispatcherCollectionInitializedEvent $event)
    {
        $collection = $event->getTaskDispatcherCollection();
        $collection->registerDispatcher(new FilesystemTaskDispatcher());
    }
}