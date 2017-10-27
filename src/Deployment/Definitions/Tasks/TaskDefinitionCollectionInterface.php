<?php

namespace Deployee\Deployment\Definitions\Tasks;

interface TaskDefinitionCollectionInterface
{
    /**
     * @param TaskDefinitionInterface $task
     */
    public function addTaskDefinition(TaskDefinitionInterface $task);

    /**
     * @return array
     */
    public function getTaskDefinitions();
}