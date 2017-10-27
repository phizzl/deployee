<?php


namespace Deployee\Plugins\DeployShopwareShop;


class ShopConfig extends \stdClass
{
    /**
     * @var array
     */
    private $config;

    /**
     * ShopConfig constructor.
     * @param string $pathToConfigInc
     */
    public function __construct($pathToConfigInc)
    {
        $this->config = require $pathToConfigInc;
    }

    /**
     * @param string $name
     * @return mixed|null
     */
    public function get($name)
    {
        return isset($this->config[$name]) ? $this->config[$name] : null;
    }
}