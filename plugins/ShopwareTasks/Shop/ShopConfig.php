<?php

namespace Deployee\Plugins\ShopwareTasks\Shop;


class ShopConfig
{
    /**
     * @var array
     */
    private $config;

    /**
     * ShopConfig constructor.
     * @param string $configFilePath
     */
    public function __construct($configFilePath)
    {
        if(!is_file($configFilePath)){
            throw new \InvalidArgumentException("Path to shopware config was not found or is invalid");
        }

        $this->config = require $configFilePath;
    }

    /**
     * @param string $id
     * @return mixed|null
     */
    public function get($id)
    {
        return isset($this->config[$id]) ? $this->config[$id] : null;
    }
}