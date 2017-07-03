<?php


namespace Phizzl\Deployee\Bootstrap;

use Phizzl\Deployee\Events\EventDispatcher;

/**
 * @mixin Bootstrap
 */
trait RegisterEventDispatcherTrait
{
    /**
     * Register the event dispatcher to the DI
     */
    private function registerEventDispatcher()
    {
        $this->getContainer()[EventDispatcher::CONTAINER_ID] = function(){
            return new EventDispatcher();
        };
    }
}