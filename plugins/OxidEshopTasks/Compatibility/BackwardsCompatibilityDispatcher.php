<?php

namespace Deployee\Plugins\OxidEshopTasks\Compatibility;


use Deployee\Deployment\Definitions\Tasks\TaskDefinitionInterface;
use Deployee\Plugins\OxidEshopTasks\Compatibility\BackwardsCompatibilityDefinition;
use Deployee\Plugins\OxidEshopTasks\Definitions\ClearShopTempDefinition;
use Deployee\Plugins\OxidEshopTasks\Definitions\CreateAdminUserDefinition;
use Deployee\Plugins\OxidEshopTasks\Definitions\GenerateViewsDefinition;
use Deployee\Plugins\RunDeploy\Dispatcher\AbstractTaskDefinitionDispatcher;
use Deployee\Plugins\RunDeploy\Dispatcher\DispatchResultInterface;

/**
 * @deprecated
 */
class BackwardsCompatibilityDispatcher extends AbstractTaskDefinitionDispatcher
{
    /**
     * @param TaskDefinitionInterface $taskDefinition
     * @return bool
     */
    public function canDispatchTaskDefinition(TaskDefinitionInterface $taskDefinition)
    {
        return $taskDefinition instanceof BackwardsCompatibilityDefinition;
    }

    /**
     * @param TaskDefinitionInterface $taskDefinition
     * @return DispatchResultInterface
     */
    public function dispatch(TaskDefinitionInterface $taskDefinition)
    {
        $parameter = $taskDefinition->define();

        if($parameter->get('cleartmp')){
            return $this->delegate(new ClearShopTempDefinition());
        }
        elseif($parameter->get('generateviews')){
            return $this->delegate(new GenerateViewsDefinition());
        }

        $adminUser = $parameter->get('adminuser');
        return $this->delegate(new CreateAdminUserDefinition($adminUser['username'], $adminUser['password']));
    }
}