<?php


namespace Deployee\Deployment;


use Deployee\Deployment\Definitions\Deployments\DeploymentDefinitionInterface;
use Deployee\Deployment\Definitions\Tasks\TaskDefinitionInterface;
use Deployee\Deployment\Finder\DeploymentDefinitionClassMapFinder;
use Deployee\Deployment\Helper\TaskCreationHelper;
use Deployee\Kernel\Modules\AbstractFactory;

class Factory extends AbstractFactory
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
    public function createTaskDefinition($className, $arguments)
    {
        $reflection = new \ReflectionClass($className);
        $definition = $reflection->getConstructor() && $reflection->getConstructor()->getNumberOfParameters() > 0
            ? $reflection->newInstanceArgs($arguments)
            : new $className;

        /* @var TaskDefinitionInterface $definition */
        if(!$definition instanceof TaskDefinitionInterface){
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
        $searchPath = $this->locator->Config()->getFacade()->get('definition_path', 'deployments');
        return new DeploymentDefinitionClassMapFinder($searchPath);
    }

    /**
     * @return TaskCreationHelper
     */
    public function createTaskCreationHelper()
    {
        return new TaskCreationHelper($this->locator);
    }
}