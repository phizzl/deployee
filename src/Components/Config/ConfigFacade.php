<?php

namespace Deployee\Components\Config;


use Deployee\Kernel\Modules\AbstractFacade;

class ConfigFacade extends AbstractFacade
{
    /**
     * @var ConfigFactory
     */
    protected $factory;

    /**
     * @var Config
     */
    private $config;

    /**
     * @param string $name
     * @param null $default
     * @return mixed
     */
    public function get($name, $default = null)
    {
        return $this->getConfigObject()->get($name, $default);
    }

    /**
     * @return Config
     */
    private function getConfigObject()
    {
        if($this->config === null){
            $this->config = $this->factory->createConfig();
        }

        return $this->config;
    }
}