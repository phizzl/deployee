<?php

namespace Deployee\Plugins\BackwardsCompatibility;


use Deployee\Dependency\DependencyInjectionProviderInterface;
use Deployee\Deployment\Helper\TaskCreationHelper;
use Deployee\Deployment\Module;
use Deployee\Kernel\Locator;

class DependencyInjectionProvider implements DependencyInjectionProviderInterface
{
    /**
     * @param Locator $locator
     */
    public function injectDependencies(Locator $locator)
    {
        if(!class_exists('\Deployee\Plugins\Deploy\Definitions\AbstractDeploymentDefinition')){
            class_alias(
                '\Deployee\Deployment\Definitions\Deployments\AbstractDeployment',
                '\Deployee\Plugins\Deploy\Definitions\AbstractDeploymentDefinition'
            );
        }

        $locator->Dependency()->extendDependency(Module::DEFINITION_HELPER_TASK_CREATION_DEPENDENCY, function(TaskCreationHelper $helper){
            $helper->addAlias('mysqlfile', 'Deployee\Plugins\MySqlTasks\Definitions\MySqlFileDefinition');
            $helper->addAlias('mysqlquery', 'Deployee\Plugins\MySqlTasks\Definitions\MySqlQueryDefinition');
            return $helper;
        });
    }
}