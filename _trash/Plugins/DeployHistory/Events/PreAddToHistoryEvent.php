<?php

namespace Deployee\Plugins\DeployHistory\Events;


use Deployee\Container;
use Deployee\Plugins\Deploy\Definitions\DeploymentDefinitionInterface;
use Symfony\Component\EventDispatcher\Event;

class PreAddToHistoryEvent extends Event
{
    const EVENT_NAME = "plugin.history.preaddtohistory";

    /**
     * @var Container
     */
    private $container;

    /**
     * @var DeploymentDefinitionInterface
     */
    private $definition;

    /**
     * @var bool
     */
    private $canStore;

    /**
     * ApplicationInitializedEvent constructor.
     * @param Container $container
     * @param DeploymentDefinitionInterface $definition
     */
    public function __construct(Container $container, DeploymentDefinitionInterface $definition)
    {
        $this->container = $container;
        $this->definition = $definition;
        $this->canStore = true;
    }

    /**
     * @return Container
     */
    public function getContainer()
    {
        return $this->container;
    }

    /**
     * @return DeploymentDefinitionInterface
     */
    public function getDefinition()
    {
        return $this->definition;
    }

    /**
     * @param bool $canStore
     */
    public function setCanStore($canStore)
    {
        $this->canStore = $canStore;
    }

    /**
     * @return bool
     */
    public function canStore()
    {
        return $this->canStore;
    }
}