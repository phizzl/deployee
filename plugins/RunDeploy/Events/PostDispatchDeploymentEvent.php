<?php

namespace Deployee\Plugins\RunDeploy\Events;


use Deployee\Deployment\Definitions\Deployments\DeploymentDefinitionInterface;
use Deployee\Events\AbstractEvent;

class PostDispatchDeploymentEvent extends AbstractEvent
{
    /**
     * @var DeploymentDefinitionInterface
     */
    private $definition;

    /**
     * @var bool
     */
    private $success;

    /**
     * PostDispatchDeploymentEvent constructor.
     * @param DeploymentDefinitionInterface $definition
     * @param bool $success
     */
    public function __construct(DeploymentDefinitionInterface $definition, $success)
    {
        $this->definition = $definition;
        $this->success = $success;
    }

    /**
     * @return DeploymentDefinitionInterface
     */
    public function getDefinition()
    {
        return $this->definition;
    }

    /**
     * @return bool
     */
    public function isSuccess()
    {
        return $this->success;
    }
}