<?php

namespace Deployee\Plugins\OxidEshopTasks\Dispatcher;


use Deployee\Deployment\Definitions\Tasks\TaskDefinitionInterface;
use Deployee\Plugins\OxidEshopTasks\Definitions\GenerateViewsDefinition;
use Deployee\Plugins\RunDeploy\Dispatcher\AbstractTaskDefinitionDispatcher;
use Deployee\Plugins\RunDeploy\Dispatcher\DispatchResultInterface;
use Deployee\Plugins\ShellTasks\Definitions\ShellTaskDefinition;

class GenerateViewsDispatcher extends AbstractTaskDefinitionDispatcher
{
    /**
     * @param TaskDefinitionInterface $taskDefinition
     * @return bool
     */
    public function canDispatchTaskDefinition(TaskDefinitionInterface $taskDefinition)
    {
        return $taskDefinition instanceof GenerateViewsDefinition;
    }

    /**
     * @param TaskDefinitionInterface $taskDefinition
     * @return DispatchResultInterface
     */
    public function dispatch(TaskDefinitionInterface $taskDefinition)
    {
        $shellTask = new ShellTaskDefinition('vendor/bin/oxid');
        $shellTask->arguments('oxid:db:generate-views');

        return $this->delegate($shellTask);
    }
}