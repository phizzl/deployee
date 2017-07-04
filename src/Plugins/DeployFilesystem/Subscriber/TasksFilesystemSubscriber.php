<?php

namespace Phizzl\Deployee\Plugins\DeployFilesystem\Subscriber;


use Phizzl\Deployee\Events\TaskDispatcherCollectionInitializedEvent;
use Phizzl\Deployee\Plugins\Deploy\Events\TaskHelperCreatedEvent;
use Phizzl\Deployee\Plugins\DeployFilesystem\Dispatcher\FilesystemTaskDispatcher;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class TasksFilesystemSubscriber implements EventSubscriberInterface
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
        $taskHelper->registerTask('Phizzl\Deployee\Plugins\DeployFilesystem\Tasks\DirectoryTask', 'directory');
        $taskHelper->registerTask('Phizzl\Deployee\Plugins\DeployFilesystem\Tasks\FileTask', 'file');
        $taskHelper->registerTask('Phizzl\Deployee\Plugins\DeployFilesystem\Tasks\PermissionsTask', 'permission');
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