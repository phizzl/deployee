<?php

namespace Deployee\Plugins\Pdo;


use Deployee\Dependency\DependencyProviderInterface;
use Deployee\Kernel\Locator;

class DependencyProvider implements DependencyProviderInterface
{
    /**
     * @param Locator $locator
     */
    public function defineDependencies(Locator $locator)
    {
        $locator->Dependency()->setDependency(Module::PDO_DEPENDENCY, function() use ($locator){
            $credentials = $locator->Dependency()->getDependency(\Deployee\Plugins\MySqlTasks\Module::CREDENTIALS_DEPENDENCY);
            return $locator->Pdo()->getFactory()->createPdo($credentials);
        });
    }

}