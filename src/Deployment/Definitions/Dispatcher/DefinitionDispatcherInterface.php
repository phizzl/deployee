<?php

namespace Deployee\Deployment\Definitions\Dispatcher;


use Deployee\Deployment\Definitions\Tasks\TaskDefinitionInterface;

interface DefinitionDispatcherInterface
{
    /**
     * @param TaskDefinitionInterface $taskDefinition
     * @return string
     */
    public function canDispatchTaskDefinition(TaskDefinitionInterface $taskDefinition);

    /**
     * @param TaskDefinitionInterface $taskDefinition
     * @return DispatchResultInterface
     */
    public function dispatch(TaskDefinitionInterface $taskDefinition);
}