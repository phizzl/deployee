<?php

namespace Deployee\Plugins\MySqlTasks;


use Deployee\Dependency\DependencyProviderInterface;
use Deployee\Kernel\Locator;

class DependencyProvider implements DependencyProviderInterface
{
    /**
     * @param Locator $locator
     */
    public function defineDependencies(Locator $locator)
    {
        $locator->Dependency()->setDependency(Module::CREDENTIALS_DEPENDENCY, function() use($locator){
            return $locator->MySqlTasks()->getFactory()->createCredentials();
        });
    }

}