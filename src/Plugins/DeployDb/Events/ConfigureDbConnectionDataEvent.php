<?php


namespace Deployee\Plugins\DeployDb\Events;


use Deployee\Container;
use Symfony\Component\EventDispatcher\Event;

class ConfigureDbConnectionDataEvent extends Event
{
    const EVENT_NAME = "plugin.db.configconnection";

    /**
     * @var Container
     */
    private $container;

    /**
     * @var array
     */
    private $config;

    /**
     * PluginsInitializedEvent constructor.
     * @param Container $container
     */
    public function __construct(Container $container, array $config)
    {
        $this->container = $container;
        $this->config = $config;
    }

    /**
     * @return Container
     */
    public function getContainer()
    {
        return $this->container;
    }

    /**
     * @return array
     */
    public function getConfig()
    {
        return $this->config;
    }

    /**
     * @param array $config
     */
    public function setConfig($config)
    {
        $this->config = $config;
    }
}