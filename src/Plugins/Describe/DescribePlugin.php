<?php

namespace Deployee\Plugins\Describe;


use Deployee\Container;
use Deployee\Plugins\AbstractPlugin;
use Deployee\Plugins\Describe\Subscriber\DescribePluginSubscriber;

class DescribePlugin extends AbstractPlugin
{
    const PLUGIN_ID = "describe";

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
        $container->events()->addSubscriber(new DescribePluginSubscriber());
    }

}