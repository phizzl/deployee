<?php

namespace Phizzl\Deployee\Plugins\FilesystemTasks;


use Phizzl\Deployee\Container;
use Phizzl\Deployee\Plugins\AbstractPlugin;

class FilesystemTasksPlugin extends AbstractPlugin
{
    const PLUGIN_ID = "filesystemtasks";

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