<?php

namespace Deployee\Plugins\DeployHistory;


use Deployee\Container;
use Deployee\Plugins\AbstractPlugin;

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

    }

}