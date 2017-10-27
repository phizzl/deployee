<?php


namespace Deployee\Deployment\Dependency;


use Deployee\Dependency\DependencyProviderInterface;
use Deployee\Deployment\DeploymentModule;
use Deployee\Deployment\Finder\DeploymentDefinitionClassMapFinder;
use Deployee\Kernel\Locator;

class DeploymentDependencyProvider implements DependencyProviderInterface
{
    public function defineDependencies(Locator $locator)
    {
        $locator->Dependency()->getFacade()->setDependency(
            DeploymentModule::DEPLOYMENT_DEFINITION_FINDER_DEPENDENCY, function() use($locator){
                $searchPath = $locator->Config()->getFacade()->get('definition_path');
                return new DeploymentDefinitionClassMapFinder($searchPath);
            }
        );
    }

}