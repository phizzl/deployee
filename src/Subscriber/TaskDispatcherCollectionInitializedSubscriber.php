<?php


namespace Phizzl\Deployee\Subscriber;


use Phizzl\Deployee\Dispatcher\Filesystem\FilesystemTaskDispatcher;
use Phizzl\Deployee\Events\TaskDispatcherCollectionInitializedEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class TaskDispatcherCollectionInitializedSubscriber implements EventSubscriberInterface
{
    /**
     * @return array
     */
    public static function getSubscribedEvents()
    {
        return [
            TaskDispatcherCollectionInitializedEvent::EVENT_NAME => 'onTaskDispatcherCollectionInitialized'
        ];
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