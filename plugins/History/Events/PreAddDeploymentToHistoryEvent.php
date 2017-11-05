<?php

namespace Deployee\Plugins\History\Events;


use Deployee\Deployment\Definitions\Deployments\DeploymentDefinitionInterface;
use Deployee\Events\AbstractEvent;

class PreAddDeploymentToHistoryEvent extends AbstractEvent
{
    /**
     * @var DeploymentDefinitionInterface
     */
    private $definition;

    /**
     * @var bool
     */
    private $preventFromAdding;

    /**
     * PreAddDeploymentToHistoryEvent constructor.
     * @param DeploymentDefinitionInterface $deployment
     */
    public function __construct(DeploymentDefinitionInterface $definition)
    {
        $this->definition = $definition;
        $this->preventFromAdding = false;
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
    public function isPreventFromAdding()
    {
        return $this->preventFromAdding;
    }

    /**
     * @param bool $preventFromAdding
     */
    public function setPreventFromAdding($preventFromAdding)
    {
        $this->preventFromAdding = $preventFromAdding;
    }
}