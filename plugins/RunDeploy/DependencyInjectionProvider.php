<?php

namespace Deployee\Plugins\RunDeploy;


use Deployee\Application\Module;
use Deployee\Application\Business\CommandCollection;
use Deployee\Dependency\DependencyInjectionProviderInterface;
use Deployee\Kernel\Locator;
use Deployee\Plugins\RunDeploy\Commands\DeployRunCommand;
use Deployee\Plugins\RunDeploy\Commands\InstallCommand;

class DependencyInjectionProvider implements DependencyInjectionProviderInterface
{
    /**
     * @param Locator $locator
     */
    public function injectDependencies(Locator $locator)
    {
        $locator->Dependency()->extendDependency(
            Module::COMMAND_COLLECTION_DEPENDENCY,
            function (CommandCollection $collection){
                $collection->addCommand(new DeployRunCommand());
                $collection->addCommand(new InstallCommand());
                return $collection;
            }
        );
    }

}