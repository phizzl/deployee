<?php


namespace Deployee\Plugins\DeployDb\Subscriber;


use Deployee\Events\TaskDispatcherCollectionInitializedEvent;
use Deployee\Plugins\Deploy\Events\TaskHelperCreatedEvent;
use Deployee\Plugins\DeployDb\Dispatcher\MySqlTaskDispatcher;
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
        $taskHelper->registerTask('Deployee\Plugins\DeployDb\Tasks\MySqlDumpTask', 'mysqldump');
        $taskHelper->registerTask('Deployee\Plugins\DeployDb\Tasks\MySqlFileImportTask', 'mysqlfile');
        $taskHelper->registerTask('Deployee\Plugins\DeployDb\Tasks\MySqlExecuteCommandTask', 'mysqlcmd');
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