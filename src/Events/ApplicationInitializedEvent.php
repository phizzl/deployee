<?php


namespace Deployee\Events;


use Deployee\Application\Application;
use Deployee\Container;
use Symfony\Component\EventDispatcher\Event;

class ApplicationInitializedEvent extends Event
{
    const EVENT_NAME = "deployee.application.initialized";

    /**
     * @var Container
     */
    private $container;

    /**
     * @var Application
     */
    private $application;

    /**
     * ApplicationInitializedEvent constructor.
     * @param Container $container
     * @param Application $application
     */
    public function __construct(Container $container, Application $application)
    {
        $this->container = $container;
        $this->application = $application;
    }

    /**
     * @return Container
     */
    public function getContainer()
    {
        return $this->container;
    }

    /**
     * @return Application
     */
    public function getApplication()
    {
        return $this->application;
    }
}