<?php

namespace Deployee\Plugins\RunDeploy\Events;


use Deployee\Deployment\Definitions\Deployments\DeploymentDefinitionInterface;
use Deployee\Events\AbstractEvent;

class PreDispatchDeploymentEvent extends AbstractEvent
{
    /**
     * @var DeploymentDefinitionInterface
     */
    private $definition;

    /**
     * PreDispatchDeploymentEvent constructor.
     * @param DeploymentDefinitionInterface $definition
     */
    public function __construct(DeploymentDefinitionInterface $definition)
    {
        $this->definition = $definition;
    }

    /**
     * @return DeploymentDefinitionInterface
     */
    public function getDefinition()
    {
        return $this->definition;
    }
}