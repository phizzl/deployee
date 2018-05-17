<?php

namespace Deployee\Config;


use Deployee\Kernel\Modules\AbstractFactory;

class Factory extends AbstractFactory
{
    /**
     * @param $params
     * @return Config
     */
    public function createConfig($params)
    {
        $params['cwd'] = getcwd();
        $config = new Config();
        $config->setParams($params);

        return $config;
    }
}