<?php

namespace Deployee\Application;


use Deployee\Application\Business\Application;
use Deployee\Application\Business\CommandCollection;
use Deployee\Dependency\DependencyProviderInterface;
use Deployee\Kernel\Locator;

class ApplicationDependencyProvider implements DependencyProviderInterface
{
    /**
     * @param Locator $locator
     */
    public function defineDependencies(Locator $locator)
    {
        $locator
            ->Dependency()
            ->getFacade()
            ->setDependency(ApplicationModule::COMMAND_COLLECTION_DEPENDENCY, function(){
                return new CommandCollection();
            });

        $locator
            ->Dependency()
            ->getFacade()
            ->setDependency(ApplicationModule::APPLICATION_DEPENDENCY, function() use($locator){
                /* @var CommandCollection $commandCollection */
                $commandCollection = $locator->Dependency()->getFacade()->getDependency(ApplicationModule::COMMAND_COLLECTION_DEPENDENCY);

                $app = new Application("Deployee");
                $app->setLocator($locator);
                $app->addCommands($commandCollection->getCommands());

                return $app;
            });
    }
}