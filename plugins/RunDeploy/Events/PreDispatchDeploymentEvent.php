<?php

namespace Deployee\Plugins\RunDeploy\Events;


use Deployee\Events\AbstractEvent;
use Deployee\Plugins\Deploy\Definitions\DeploymentDefinitionInterface;

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