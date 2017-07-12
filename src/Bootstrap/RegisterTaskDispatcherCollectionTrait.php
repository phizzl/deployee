<?php


namespace Deployee\Bootstrap;

use Deployee\Dispatcher\TaskDispatcherCollection;
use Deployee\Events\TaskDispatcherCollectionInitializedEvent;

/**
 * @mixin Bootstrap
 */
trait RegisterTaskDispatcherCollectionTrait
{
    /**
     * Register the config loader to the DI container
     */
    private function registerTaskDispatcherCollection()
    {
        $this->getContainer()[TaskDispatcherCollection::CONTAINER_ID] = function(){
            $collection = new TaskDispatcherCollection();
            $event = new TaskDispatcherCollectionInitializedEvent($this->container, $collection);
            $this->container->events()->dispatch(TaskDispatcherCollectionInitializedEvent::EVENT_NAME, $event);

            return $collection;
        };
    }
}