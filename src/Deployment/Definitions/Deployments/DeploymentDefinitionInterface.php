<?php


namespace Deployee\Deployment\Definitions\Deployments;


use Deployee\Deployment\Definitions\DefinitionInterface;
use Deployee\Deployment\Definitions\Tasks\TaskDefinitionInterface;
use Deployee\Tasks\TaskCollectionInterface;

interface DeploymentDefinitionInterface extends DefinitionInterface
{
    /**
     * @param TaskDefinitionInterface $task
     */
    public function addTask(TaskDefinitionInterface $task);

    /**
     * @return TaskCollectionInterface
     */
    public function getTasks();
}