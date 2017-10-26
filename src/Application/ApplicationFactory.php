<?php

namespace Deployee\Application;


use Deployee\Application\Business\Application;
use Deployee\Kernel\Modules\AbstractFactory;

class ApplicationFactory extends AbstractFactory
{
    /**
     * @return Application
     */
    public function createApplication()
    {
        return $this->locator->Dependency()->getFacade()->getDependency(ApplicationModule::APPLICATION_DEPENDENCY);
    }
}