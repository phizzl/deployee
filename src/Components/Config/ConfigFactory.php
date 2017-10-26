<?php

namespace Deployee\Components\Config;


use Deployee\Kernel\Modules\FactoryInterface;

class ConfigFactory implements FactoryInterface
{

    public function createConfig()
    {
        return new Config();
    }
}