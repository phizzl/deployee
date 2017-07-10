<?php


namespace Phizzl\Deployee\Events;


use Phizzl\Deployee\Container;
use Symfony\Component\EventDispatcher\Event;

class BootstrapFinishedEvent extends Event
{
    const EVENT_NAME = "deployee.bootstrap.finished";

    /**
     * @var Container
     */
    private $container;

    /**
     * PluginsInitializedEvent constructor.
     * @param Container $container
     */
    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    /**
     * @return Container
     */
    public function getContainer()
    {
        return $this->container;
    }
}