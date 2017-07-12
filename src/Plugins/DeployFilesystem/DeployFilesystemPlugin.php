<?php

namespace Deployee\Plugins\DeployFilesystem;


use Deployee\Container;
use Deployee\Plugins\AbstractPlugin;
use Deployee\Plugins\DeployFilesystem\Subscriber\DeployFilesystemSubscriber;

class DeployFilesystemPlugin extends AbstractPlugin
{
    const PLUGIN_ID = "deploy.filesystem";

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
        if(!class_exists('Deployee\Plugins\Deploy\DeployPlugin')){
            throw new \RuntimeException("DeployPlugin is required!");
        }

        $container->events()->addSubscriber(new DeployFilesystemSubscriber());
    }
}