<?php

namespace Deployee\Plugins\DeployDb;


use Deployee\Container;
use Deployee\Plugins\AbstractPlugin;
use Deployee\Plugins\DeployDb\Subscriber\DeployDbSubscriber;

class DeployDbPlugin extends AbstractPlugin
{
    const PLUGIN_ID = "deploy.db";

    /**
     * @return string
     */
    public function getPluginId()
    {
        return self::PLUGIN_ID;
    }

    /**
     * @param Container $container
     */
    public function initialize(Container $container)
    {
        $this->config['host'] = isset($this->config['host']) ? $this->config['host'] : "localhost";
        $this->config['port'] = isset($this->config['port']) ? $this->config['port'] : 3306;

        foreach(['user', 'name'] as $configName){
            if(!isset($this->config[$configName])
                || trim($this->config[$configName]) === ""){
                throw new \RuntimeException("You must specify \"$configName\"");
            }
        }

        $container->events()->addSubscriber(new DeployDbSubscriber());
    }

}