<?php

namespace Deployee\Plugins\GenerateDeploy;


use Deployee\Application\Business\CommandCollection;
use Deployee\Application\Module;
use Deployee\Dependency\DependencyInjectionProviderInterface;
use Deployee\Kernel\Locator;
use Deployee\Plugins\GenerateDeploy\Commands\GenerateDeployCommand;

class DependencyInjectionProvider implements DependencyInjectionProviderInterface
{
    /**
     * @param Locator $locator
     */
    public function injectDependencies(Locator $locator)
    {
        $locator->Dependency()->extendDependency(Module::COMMAND_COLLECTION_DEPENDENCY, function(CommandCollection $collection) use($locator){
            $collection->addCommand(new GenerateDeployCommand());
            return $collection;
        });
    }

}