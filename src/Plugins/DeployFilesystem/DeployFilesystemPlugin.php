<?php

namespace Phizzl\Deployee\Plugins\DeployFilesystem;


use Phizzl\Deployee\Container;
use Phizzl\Deployee\Plugins\AbstractPlugin;
use Phizzl\Deployee\Plugins\DeployFilesystem\Subscriber\DeployFilesystemSubscriber;

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
        if(!class_exists('Phizzl\Deployee\Plugins\Deploy\DeployPlugin')){
            throw new \RuntimeException("DeployPlugin is required!");
        }

        $container->events()->addSubscriber(new DeployFilesystemSubscriber());
    }
}