<?php

namespace Phizzl\Deployee;


use Composer\Autoload\ClassLoader;
use Phizzl\Deployee\Config\Config;
use Phizzl\Deployee\Dispatcher\TaskDispatcherCollection;
use Phizzl\Deployee\Events\EventDispatcher;
use Phizzl\Deployee\Logger\Logger;
use Phizzl\Deployee\Plugins\PluginContainer;

class Container extends \Pimple\Container
{
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