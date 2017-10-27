<?php


namespace Deployee\Deployment;


use Deployee\Deployment\Definitions\Deployments\DeploymentDefinitionInterface;
use Deployee\Deployment\Definitions\Tasks\TaskDefinitionInterface;
use Deployee\Deployment\Finder\DeploymentDefinitionClassMapFinder;
use Deployee\Kernel\Modules\AbstractFactory;

class DeploymentFactory extends AbstractFactory
{
    /**
     * @param string $className
     * @return DeploymentDefinitionInterface
     */
    public function createDeploymentDefinition($className)
    {
        /* @var DeploymentDefinitionInterface $definition */
        if(!($definition = new $className) instanceof DeploymentDefinitionInterface){
            throw new \RuntimeException("Invalid deployment definition class \"{$className}\"");
        }

        $definition->setLocator($this->locator);

        return $definition;
    }

    /**
     * @param string $className
     * @return TaskDefinitionInterface
     */
    public function createTaskDefinition($className)
    {
        /* @var TaskDefinitionInterface $definition */
        if(!($definition = new $className) instanceof TaskDefinitionInterface){
            throw new \RuntimeException("Invalid task definition class \"{$className}\"");
        }

        $definition->setLocator($this->locator);

        return $definition;
    }

    /**
     * @return DeploymentDefinitionClassMapFinder
     */
    public function createDefinitionFinder()
    {
        return $this->locator->Dependency()->getFacade()->getDependency(DeploymentModule::DEPLOYMENT_DEFINITION_FINDER_DEPENDENCY);
    }
}