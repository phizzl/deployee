<?php

namespace Deployee\Plugins\ShopwareTasks;


use Deployee\Dependency\DependencyProviderInterface;
use Deployee\Kernel\Locator;
use Deployee\Plugins\ShopwareTasks\Shop\ShopConfig;

class DependencyProvider implements DependencyProviderInterface
{
    /**
     * @param Locator $locator
     */
    public function defineDependencies(Locator $locator)
    {
        $locator->Dependency()->getFacade()->setDependency(Module::SHOP_CONFIG_DEPENDENCY, function() use ($locator){
            if(!($shopPath = realpath($locator->Config()->getFacade()->get('shopware.path')))
                || !is_file($shopPath . '/config.php')){
                throw new \InvalidArgumentException(sprintf("You must define the config var \"%s\"", "shopware.path"));
            }

            return new ShopConfig($shopPath . '/config.php');
        });
    }

}