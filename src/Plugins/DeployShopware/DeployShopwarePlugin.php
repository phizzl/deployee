<?php


namespace Deployee\Plugins\DeployOxid;


use Deployee\Container;
use Deployee\Plugins\AbstractPlugin;
use Deployee\Plugins\DeployShopware\Subscriber\DeployShopwareSubscriber;

class DeployShopwarePlugin extends AbstractPlugin
{
    const PLUGIN_ID = "deploy.shopware";

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
        $container->events()->addSubscriber(new DeployShopwareSubscriber());
    }
}