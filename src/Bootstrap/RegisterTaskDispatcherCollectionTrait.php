<?php


namespace Phizzl\Deployee\Bootstrap;

use Phizzl\Deployee\Dispatcher\TaskDispatcherCollection;

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
            return new TaskDispatcherCollection();
        };
    }
}