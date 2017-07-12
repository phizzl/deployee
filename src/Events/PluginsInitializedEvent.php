<?php


namespace Deployee\Events;


use Deployee\Container;
use Deployee\Plugins\PluginContainer;
use Symfony\Component\EventDispatcher\Event;

class PluginsInitializedEvent extends Event
{
    const EVENT_NAME = "deployee.plugins.initialized";

    /**
     * @var Container
     */
    private $container;

    /**
     * @var PluginContainer
     */
    private $plugins;

    /**
     * PluginsInitializedEvent constructor.
     * @param Container $container
     * @param PluginContainer $plugins
     */
    public function __construct(Container $container, PluginContainer $plugins)
    {
        $this->container = $container;
        $this->plugins = $plugins;
    }

    /**
     * @return Container
     */
    public function getContainer()
    {
        return $this->container;
    }

    /**
     * @return PluginContainer
     */
    public function getPlugins()
    {
        return $this->plugins;
    }
}