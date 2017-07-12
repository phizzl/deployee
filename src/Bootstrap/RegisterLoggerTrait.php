<?php


namespace Deployee\Bootstrap;

use Deployee\Logger\Logger;

/**
 * @mixin Bootstrap
 */
trait RegisterLoggerTrait
{
    /**
     * Register the event dispatcher to the DI
     */
    private function registerLogger()
    {
        $this->getContainer()[Logger::CONTAINER_ID] = function(){
            return new Logger("Deployee");
        };
    }
}