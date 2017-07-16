<?php


namespace Deployee\Plugins\DeployOxid\Shop;


class ShopConfig extends \stdClass
{
    /**
     * ShopConfig constructor.
     * @param string $pathToConfigInc
     */
    public function __construct($pathToConfigInc)
    {
        require $pathToConfigInc;
    }

    /**
     * @param string $name
     * @return mixed|null
     */
    public function get($name)
    {
        return isset($this->{$name}) ? $this->{$name} : null;
    }
}