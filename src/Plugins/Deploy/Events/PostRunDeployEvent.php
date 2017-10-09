<?php


namespace Deployee\Plugins\Deploy\Events;

use Deployee\Container;
use Deployee\Plugins\Deploy\Definitions\DeploymentDefinitionInterface;
use Symfony\Component\EventDispatcher\Event;

class PostRunDeployEvent extends Event
{
    const EVENT_NAME = "deployee.plugin.deploy.run.post";

    /**
     * @var Container
     */
    private $container;

    /**
     * @var DeploymentDefinitionInterface
     */
    private $definition;

    /**
     * PluginsInitializedEvent constructor.
     * @param Container $container
     * @param DeploymentDefinitionInterface $definition
     */
    public function __construct(Container $container, DeploymentDefinitionInterface $definition)
    {
        $this->container = $container;
        $this->definition = $definition;
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
}