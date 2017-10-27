<?php

namespace Deployee\Plugins\Deploy;


use Deployee\Container;
use Deployee\Plugins\AbstractPlugin;
use Deployee\Plugins\Deploy\Events\TaskHelperCreatedEvent;
use Deployee\Plugins\Deploy\Subscriber\ApplicationSubscriber;
use Deployee\Plugins\Deploy\Tasks\TaskHelper;

class DeployPlugin extends AbstractPlugin
{
    const PLUGIN_ID = "deploy";

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
        $this->validateConfiguration();

        $container->classLoader()->add("\\", $this->config['path']);
        $container->events()->addSubscriber(new ApplicationSubscriber($this));

        $container[TaskHelper::CONTAINER_ID] = function(Container $di){
            $helper = new TaskHelper();
            $event = new TaskHelperCreatedEvent($di, $helper);
            $di->events()->dispatch(TaskHelperCreatedEvent::EVENT_NAME, $event);
            return $helper;
        };
    }

    /**
     * @throws \RuntimeException
     */
    private function validateConfiguration()
    {
        if(!isset($this->config['path'])
            || !($path = $this->config['path'])){
            throw new \RuntimeException("You must specify the path to store and read the deployment definitions from");
        }

        if(substr($path, 0, 1) !== '/'
            && substr($path, 1, 1) !== ':'){
            $path = getcwd() . DIRECTORY_SEPARATOR . $path;
        }

        $realpath = realpath($path);

        $this->config['path'] = $realpath;
    }
}