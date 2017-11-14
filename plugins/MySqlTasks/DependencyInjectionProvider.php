<?php

namespace Deployee\Plugins\MySqlTasks;


use Deployee\Dependency\DependencyInjectionProviderInterface;
use Deployee\Deployment\Helper\TaskCreationHelper;
use Deployee\Deployment\Module;
use Deployee\Kernel\Locator;
use Deployee\Plugins\RunDeploy\Dispatcher\DispatcherCollection;

class DependencyInjectionProvider implements DependencyInjectionProviderInterface
{
    /**
     * @param Locator $locator
     */
    public function injectDependencies(Locator $locator)
    {
        $locator->Dependency()->extendDependency(Module::DEFINITION_HELPER_TASK_CREATION_DEPENDENCY, function(TaskCreationHelper $helper){
            $helper->addAlias('mysqlFile', 'Deployee\Plugins\MySqlTasks\Definitions\MySqlFileDefinition');
            $helper->addAlias('mysqlQuery', 'Deployee\Plugins\MySqlTasks\Definitions\MySqlQueryDefinition');
            return $helper;
        });

        $locator->Dependency()->extendDependency(\Deployee\Plugins\RunDeploy\Module::DISPATCHER_COLLECTION_DEPENDENCY, function(DispatcherCollection $collection) use($locator){
            $collection->addDispatcher(
                $locator->RunDeploy()->getFactory()->createDispatcher('Deployee\Plugins\MySqlTasks\Dispatcher\MySqlFileDispatcher')
            );

            $collection->addDispatcher(
                $locator->RunDeploy()->getFactory()->createDispatcher('Deployee\Plugins\MySqlTasks\Dispatcher\MySqlQueryDispatcher')
            );

            return $collection;
        });

        $this->backwardsCompatibility($locator);
    }

    /**
     * @deprecated
     * @param Locator $locator
     */
    private function backwardsCompatibility(Locator $locator)
    {
        $locator->Dependency()->extendDependency(Module::DEFINITION_HELPER_TASK_CREATION_DEPENDENCY, function(TaskCreationHelper $helper){
            $helper->addAlias('mysqlcmd', 'Deployee\Plugins\MySqlTasks\Definitions\MySqlQueryDefinition');
            return $helper;
        });
    }
}