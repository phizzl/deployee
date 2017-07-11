<?php


namespace Phizzl\Deployee\Plugins\DeployDb\Subscriber;


use Phizzl\Deployee\Events\TaskDispatcherCollectionInitializedEvent;
use Phizzl\Deployee\Plugins\Deploy\Events\TaskHelperCreatedEvent;
use Phizzl\Deployee\Plugins\DeployDb\Dispatcher\MySqlTaskDispatcher;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class DeployDbSubscriber implements EventSubscriberInterface
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
        $taskHelper->registerTask('Phizzl\Deployee\Plugins\DeployDb\Tasks\MySqlDumpTask', 'mysqldump');
        $taskHelper->registerTask('Phizzl\Deployee\Plugins\DeployDb\Tasks\MySqlFileImportTask', 'mysqlfile');
    }

    /**
     * @param TaskDispatcherCollectionInitializedEvent $event
     */
    public function onTaskDispatcherCollectionInitialized(TaskDispatcherCollectionInitializedEvent $event)
    {
        $collection = $event->getTaskDispatcherCollection();
        $collection->registerDispatcher(new MySqlTaskDispatcher($event->getContainer()));
    }
}