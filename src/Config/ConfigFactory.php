<?php

namespace Deployee\Config;


use Deployee\Kernel\Modules\AbstractFactory;

class ConfigFactory extends AbstractFactory
{
    public function createConfig()
    {
        return new Config();
    }
}