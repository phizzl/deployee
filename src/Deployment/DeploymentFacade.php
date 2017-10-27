<?php


namespace Deployee\Deployment;


use Deployee\Kernel\Modules\AbstractFacade;

class DeploymentFacade extends AbstractFacade
{
    /**
     * @var DeploymentFactory
     */
    protected $factory;

    /**
     * @return array
     */
    public function findDeploymentDefinitions()
    {
        $classMap = $this->factory->createDefinitionFinder()->getClassMap();
        $loadClassMap = array_filter($classMap, function($className){
            return !class_exists($className);
        }, ARRAY_FILTER_USE_KEY);

        $this->locator->ClassLoader()->getFacade()->addClassMap($loadClassMap);

        return array_keys($classMap);
    }
}