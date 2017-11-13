<?php

namespace Deployee\Plugins\OxidEshopTasks\Dispatcher;


use Deployee\Deployment\Definitions\Tasks\TaskDefinitionInterface;
use Deployee\Plugins\OxidEshopTasks\Definitions\ModuleDefinition;
use Deployee\Plugins\RunDeploy\Dispatcher\AbstractTaskDefinitionDispatcher;
use Deployee\Plugins\RunDeploy\Dispatcher\DispatchResultInterface;
use Deployee\Plugins\ShellTasks\Definitions\ShellTaskDefinition;

class ModuleDispatcher extends AbstractTaskDefinitionDispatcher
{
    /**
     * @param TaskDefinitionInterface $taskDefinition
     * @return bool
     */
    public function canDispatchTaskDefinition(TaskDefinitionInterface $taskDefinition)
    {
        return $taskDefinition instanceof ModuleDefinition;
    }

    /**
     * @param TaskDefinitionInterface $taskDefinition
     * @return DispatchResultInterface
     */
    public function dispatch(TaskDefinitionInterface $taskDefinition)
    {
        $parameter = $taskDefinition->define();
        $shellCommand = $parameter->get('mode') === ModuleDefinition::MODE_ACTIVATE
            ? "oxid:module:activate"
            : "oxid:module:deactivate";

        $shopIdOptions = "";
        foreach($parameter->get('shopids') as $shopId){
            $shopIdOptions .= " --shopid={$shopId}";
        }

        $shellTask = new ShellTaskDefinition($shellCommand);
        $shellTask->arguments("{$parameter->get('moduleid')} {$shopIdOptions}");

        return $this->delegate($shellTask);
    }
}