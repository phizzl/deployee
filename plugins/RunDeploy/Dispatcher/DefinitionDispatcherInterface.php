<?php

namespace Deployee\Plugins\RunDeploy\Dispatcher;


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