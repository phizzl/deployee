<?php

namespace Deployee\Plugins\OxidEshopTasks\Dispatcher;


use Deployee\Deployment\Definitions\Tasks\TaskDefinitionInterface;
use Deployee\Plugins\OxidEshopTasks\Definitions\ClearShopTempDefinition;
use Deployee\Plugins\RunDeploy\Dispatcher\AbstractTaskDefinitionDispatcher;
use Deployee\Plugins\RunDeploy\Dispatcher\DispatchResultInterface;
use Deployee\Plugins\ShellTasks\Definitions\ShellTaskDefinition;

class ClearShopTempDispatcher extends AbstractTaskDefinitionDispatcher
{
    /**
     * @param TaskDefinitionInterface $taskDefinition
     * @return bool
     */
    public function canDispatchTaskDefinition(TaskDefinitionInterface $taskDefinition)
    {
        return $taskDefinition instanceof ClearShopTempDefinition;
    }

    /**
     * @param TaskDefinitionInterface $taskDefinition
     * @return DispatchResultInterface
     */
    public function dispatch(TaskDefinitionInterface $taskDefinition)
    {
        $shellTask = new ShellTaskDefinition('vendor/bin/oxid');
        $shellTask->arguments('oxid:clear-tmp');

        return $this->delegate($shellTask);
    }
}