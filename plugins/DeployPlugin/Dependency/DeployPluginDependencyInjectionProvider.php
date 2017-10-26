<?php

namespace Deployee\Plugins\DeployPlugin\Dependency;


use Deployee\Application\ApplicationModule;
use Deployee\Application\Business\CommandCollection;
use Deployee\Dependency\DependencyInjectionProviderInterface;
use Deployee\Kernel\Locator;
use Deployee\Plugins\DeployPlugin\Commands\DeployRunCommand;

class DeployPluginDependencyInjectionProvider implements DependencyInjectionProviderInterface
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