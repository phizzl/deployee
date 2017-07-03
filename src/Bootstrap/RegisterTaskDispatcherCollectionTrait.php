<?php


namespace Phizzl\Deployee\Bootstrap;

use Phizzl\Deployee\Dispatcher\TaskDispatcherCollection;
use Phizzl\Deployee\Events\TaskDispatcherCollectionInitializedEvent;

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