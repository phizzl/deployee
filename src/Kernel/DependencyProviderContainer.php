<?php

namespace Deployee\Kernel;


use Composer\Autoload\ClassLoader;
use Deployee\Config\Config;
use Deployee\Dispatcher\TaskDispatcherCollection;
use Deployee\Events\EventDispatcher;
use Deployee\Logger\Logger;
use Deployee\Plugins\PluginContainer;

class DependencyProviderContainer extends \Pimple\Container implements DependencyProviderContainerInterface
{
    /**
     * @param string $id
     * @return mixed
     */
    public function getDependency($id)
    {
        return $this[$id];
    }

    /**
     * @return EventDispatcher
     */
    public function events()
    {
        return $this[EventDispatcher::CONTAINER_ID];
    }

    /**
     * @return Config
     */
    public function config()
    {
        return $this[Config::CONTAINER_ID];
    }

    /**
     * @return PluginContainer
     */
    public function plugins()
    {
        return $this[PluginContainer::CONTAINER_ID];
    }

    /**
     * @return ClassLoader
     */
    public function classLoader()
    {
        return $this['composer.classloader'];
    }

    /**
     * @return TaskDispatcherCollection
     */
    public function taskDispatcher()
    {
        return $this[TaskDispatcherCollection::CONTAINER_ID];
    }

    /**
     * @return Logger
     */
    public function logger()
    {
        return $this[Logger::CONTAINER_ID];
    }
}