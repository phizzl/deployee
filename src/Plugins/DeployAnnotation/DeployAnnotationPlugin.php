<?php

namespace Deployee\Plugins\DeployAnnotation;


use Deployee\Container;
use Deployee\Plugins\AbstractPlugin;
use Deployee\Plugins\DeployAnnotation\Subscriber\DeployAnnotationSubscriber;

class DeployAnnotationPlugin extends AbstractPlugin
{
    const PLUGIN_ID = "deploy.annotation";

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
        $container->events()->addSubscriber(new DeployAnnotationSubscriber());
    }
}