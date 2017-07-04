<?php

namespace Phizzl\Deployee\Plugins\TasksFilesystem;


use Phizzl\Deployee\Container;
use Phizzl\Deployee\Plugins\AbstractPlugin;
use Phizzl\Deployee\Plugins\TasksFilesystem\Subscriber\TasksFilesystemSubscriber;

class TasksFilesystemPlugin extends AbstractPlugin
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
        if(!class_exists('Phizzl\Deployee\Plugins\Deploy\DeployPlugin')){
            throw new \RuntimeException("DeployPlugin is required!");
        }

        $container->events()->addSubscriber(new TasksFilesystemSubscriber());
    }
}