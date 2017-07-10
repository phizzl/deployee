<?php

namespace Phizzl\Deployee\Plugins\DeployOxid\Dispatcher;

use Phizzl\Deployee\Plugins\DeployOxid\Tasks\ModuleTask;
use Phizzl\Deployee\Plugins\DeployShell\Dispatcher\ShellTaskDispatcher;
use Phizzl\Deployee\Plugins\DeployShell\Tasks\ShellTask;
use Phizzl\Deployee\Tasks\TaskInterface;

class OxidTaskDispatcher extends ShellTaskDispatcher
{
    /**
     * @return array
     */
    protected function getDispatchableClasses()
    {
        return [
            'Phizzl\Deployee\Plugins\DeployOxid\Tasks\ModuleTask'
        ];
    }

    /**
     * @param TaskInterface $task
     * @return int
     */
    protected function dispatchModuleTask(TaskInterface $task)
    {
        $definition = $task->getDefinition();
        $shellCommand = $definition['mode'] === ModuleTask::MODE_ACTIVATE
            ? "oxid:module:activate"
            : "oxid:module:deactivate";

        $shopIdOptions = "";
        foreach($definition['shopids'] as $shopId){
            $shopIdOptions .= "--shopid={$shopId}";
        }

        $shellTask = new ShellTask("oxid");
        $shellTask->arguments(trim("{$shellCommand} {$definition['moduleid']} {$shopIdOptions}"));

        return $this->dispatchShellTask($shellTask);
    }
}