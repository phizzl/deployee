<?php


namespace Deployee\Deployment;


use Deployee\Kernel\Modules\AbstractFacade;

class Facade extends AbstractFacade
{

    /**
     * @return array
     */
    public function findDeploymentDefinitions()
    {
        $classMap = $this->locator->Deployment()->getFactory()->createDefinitionFinder()->getClassMap();
        $loadClassMap = array_filter($classMap, function($className){
            return !class_exists($className);
        }, ARRAY_FILTER_USE_KEY);

        $this->locator->ClassLoader()->getFacade()->addClassMap($loadClassMap);

        return array_keys($classMap);
    }
}