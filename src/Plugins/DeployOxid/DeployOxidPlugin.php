<?php


namespace Phizzl\Deployee\Plugins\DeployOxid;


use Phizzl\Deployee\Container;
use Phizzl\Deployee\Plugins\AbstractPlugin;
use Phizzl\Deployee\Plugins\DeployOxid\Subscriber\DeployOxidSubscriber;

class DeployOxidPlugin extends AbstractPlugin
{
    const PLUGIN_ID = "deploy.oxideshop";

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
        $container->events()->addSubscriber(new DeployOxidSubscriber());
    }

}