<?php

namespace Deployee\Plugins\ShellTasks;


use Deployee\Dependency\DependencyProviderInterface;
use Deployee\Kernel\Locator;

class DependencyProvider implements DependencyProviderInterface
{
    /**
     * @param Locator $locator
     */
    public function defineDependencies(Locator $locator)
    {
        $locator->Dependency()->setDependency(Module::EXECUTABLE_FINDER_DEPENDENCY, function() use($locator){
            return $locator->ShellTasks()->getFactory()->createExecutableFinder();
        });
    }

}