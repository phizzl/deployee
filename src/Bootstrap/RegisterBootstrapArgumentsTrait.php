<?php


namespace Deployee\Bootstrap;
use Deployee\Container;

/**
 * @mixin Bootstrap
 */
trait RegisterBootstrapArgumentsTrait
{
    private function registerBootstrapArguments()
    {
        $this->getContainer()[BootstrapArguments::CONATINER_ID] = function(Container $container){
            return new BootstrapArguments($container['args']);
        };
    }
}