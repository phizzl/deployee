<?php

namespace Phizzl\Deployee\Plugins\Describe;


use Phizzl\Deployee\Container;
use Phizzl\Deployee\Plugins\AbstractPlugin;
use Phizzl\Deployee\Plugins\Describe\Subscriber\DescribePluginSubscriber;

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