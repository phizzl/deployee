<?php


namespace Deployee\Deployment\Definitions\Deployments;


use Deployee\Deployment\Definitions\DefinitionInterface;
use Deployee\Deployment\Definitions\Tasks\TaskDefinitionCollectionInterface;
use Deployee\Deployment\Definitions\Tasks\TaskDefinitionInterface;

interface DeploymentDefinitionInterface extends DefinitionInterface
{
    /**
     * @param TaskDefinitionInterface $task
     */
    public function addTaskDefinition(TaskDefinitionInterface $task);

    /**
     * @return TaskDefinitionCollectionInterface
     */
    public function getTaskDefinitions();
}