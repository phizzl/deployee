<?php

namespace Deployee\Config;


use Deployee\Kernel\Modules\AbstractFactory;

class ConfigFactory extends AbstractFactory
{
    /**
     * @param $params
     * @return Config
     */
    public function createConfig($params)
    {
        $config = new Config();
        $config->setParams($params);

        return $config;
    }
}