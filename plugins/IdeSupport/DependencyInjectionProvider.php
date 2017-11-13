<?php

namespace Deployee\Plugins\IdeSupport;


use Deployee\Application\Business\CommandCollection;
use Deployee\Application\Module;
use Deployee\Dependency\DependencyInjectionProviderInterface;
use Deployee\Kernel\Locator;
use Deployee\Plugins\IdeSupport\Commands\UpdateIdeSupportCommand;

class DependencyInjectionProvider implements DependencyInjectionProviderInterface
{
    /**
     * @param Locator $locator
     */
    public function injectDependencies(Locator $locator)
    {
        $locator->Dependency()->extendDependency(Module::COMMAND_COLLECTION_DEPENDENCY, function(CommandCollection $collection) use($locator){
            $collection->addCommand(new UpdateIdeSupportCommand());
            return $collection;
        });
    }
}