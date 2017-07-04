<?php

namespace Phizzl\Deployee\Plugins\DeployShell;


use Phizzl\Deployee\Container;
use Phizzl\Deployee\Plugins\AbstractPlugin;

class DeployShellPlugin extends AbstractPlugin
{
    const PLUGIN_ID = "deploy.shell";

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