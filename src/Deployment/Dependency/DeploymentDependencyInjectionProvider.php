<?php

namespace Deployee\Deployment\Dependency;


use Deployee\Application\ApplicationModule;
use Deployee\Application\Business\CommandCollection;
use Deployee\Dependency\DependencyInjectionProviderInterface;
use Deployee\Deployment\Commands\DeployRunCommand;
use Deployee\Kernel\Locator;

class DeploymentDependencyInjectionProvider implements DependencyInjectionProviderInterface
{
    /**
     * @param Locator $locator
     */
    public function injectDependencies(Locator $locator)
    {
        $locator->Dependency()->extendDependency(
            ApplicationModule::COMMAND_COLLECTION_DEPENDENCY,
            function (CommandCollection $collection){
                $collection->addCommand(new DeployRunCommand());
                return $collection;
            }
        );
    }

}