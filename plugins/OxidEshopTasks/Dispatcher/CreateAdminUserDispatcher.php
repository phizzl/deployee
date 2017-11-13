<?php

namespace Deployee\Plugins\OxidEshopTasks\Dispatcher;


use Deployee\Deployment\Definitions\Tasks\TaskDefinitionInterface;
use Deployee\Plugins\OxidEshopTasks\Definitions\CreateAdminUserDefinition;
use Deployee\Plugins\RunDeploy\Dispatcher\AbstractTaskDefinitionDispatcher;
use Deployee\Plugins\RunDeploy\Dispatcher\DispatchResultInterface;
use Deployee\Plugins\ShellTasks\Definitions\ShellTaskDefinition;

class CreateAdminUserDispatcher extends AbstractTaskDefinitionDispatcher
{
    /**
     * @param TaskDefinitionInterface $taskDefinition
     * @return bool
     */
    public function canDispatchTaskDefinition(TaskDefinitionInterface $taskDefinition)
    {
        return $taskDefinition instanceof CreateAdminUserDefinition;
    }

    /**
     * @param TaskDefinitionInterface $taskDefinition
     * @return DispatchResultInterface
     */
    public function dispatch(TaskDefinitionInterface $taskDefinition)
    {
        $parameter = $taskDefinition->define();
        $shellTask = new ShellTaskDefinition('vendor/bin/oxid');
        $shellTask->arguments(sprintf("%s %s", $parameter->get('username'), $parameter->get('password')));

        return $this->delegate($shellTask);
    }
}