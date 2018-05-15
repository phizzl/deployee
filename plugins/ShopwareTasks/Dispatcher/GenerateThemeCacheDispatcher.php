<?php

namespace Deployee\Plugins\ShopwareTasks\Dispatcher;


use Deployee\Deployment\Definitions\Tasks\TaskDefinitionInterface;
use Deployee\Plugins\RunDeploy\Dispatcher\AbstractTaskDefinitionDispatcher;
use Deployee\Plugins\ShellTasks\Definitions\ShellTaskDefinition;
use Deployee\Plugins\ShopwareTasks\Definitions\GenerateThemeCacheDefinition;

class GenerateThemeCacheDispatcher extends AbstractTaskDefinitionDispatcher
{
    /**
     * @param TaskDefinitionInterface $taskDefinition
     * @return bool
     */
    public function canDispatchTaskDefinition(TaskDefinitionInterface $taskDefinition)
    {
        return $taskDefinition instanceof GenerateThemeCacheDefinition;
    }

    /**
     * @param TaskDefinitionInterface $taskDefinition
     * @return \Deployee\Plugins\RunDeploy\Dispatcher\DispatchResultInterface
     */
    public function dispatch(TaskDefinitionInterface $taskDefinition)
    {
        $parameter = $taskDefinition->define();
        $shopIds = $parameter->get('shopId');
        $shopPath = $this->locator->Config()->getFacade()->get('shopware.path');

        $arguments = '';
        foreach($shopIds as $shopId){
            $arguments .= ' --shopId=' . $shopId;
        }

        $shellTask = new ShellTaskDefinition("{$shopPath}/bin/console");
        $shellTask->arguments(sprintf('sw:theme:cache:generate -n %s', $arguments));

        return $this->delegate($shellTask);
    }

}