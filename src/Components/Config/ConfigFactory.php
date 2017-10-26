<?php

namespace Deployee\Components\Config;


use Deployee\Kernel\Modules\AbstractFactory;

class ConfigFactory extends AbstractFactory
{
    public function createConfig()
    {
        return new Config();
    }
}