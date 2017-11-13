<?php

namespace Deployee\Plugins\DescribeDeploy;


use Deployee\Application\Business\CommandCollection;
use Deployee\Application\Module;
use Deployee\Dependency\DependencyInjectionProviderInterface;
use Deployee\Kernel\Locator;
use Deployee\Plugins\DescribeDeploy\Commands\DescribeDeployCommand;

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
                $collection->addCommand(new DescribeDeployCommand());
                return $collection;
            }
        );
    }
}