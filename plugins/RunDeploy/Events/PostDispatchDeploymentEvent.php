<?php

namespace Deployee\Plugins\RunDeploy\Events;


use Deployee\Events\AbstractEvent;
use Deployee\Plugins\Deploy\Definitions\DeploymentDefinitionInterface;
use Deployee\Plugins\RunDeploy\Dispatcher\DispatchResultInterface;

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