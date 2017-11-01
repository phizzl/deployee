<?php


namespace Deployee\Deployment;


use Deployee\Dependency\DependencyProviderInterface;
use Deployee\Deployment\Module;
use Deployee\Deployment\Finder\DeploymentDefinitionClassMapFinder;
use Deployee\Kernel\Locator;

class DependencyProvider implements DependencyProviderInterface
{
    public function defineDependencies(Locator $locator)
    {
        $locator->Dependency()->getFacade()->setDependency(
            Module::DEPLOYMENT_DEFINITION_FINDER_DEPENDENCY, function() use($locator){
                return $locator->Deployment()->getFactory()->createDefinitionFinder();
            }
        );

        $locator->Dependency()->getFacade()->setDependency(Module::DEFINITION_HELPER_TASK_CREATION_DEPENDENCY, function() use($locator){
            return $locator->Deployment()->getFactory()->createTaskCreationHelper();
        });
    }

}