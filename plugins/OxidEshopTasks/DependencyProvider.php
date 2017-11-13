<?php

namespace Deployee\Plugins\OxidEshopTasks;


use Deployee\Dependency\DependencyProviderInterface;
use Deployee\Kernel\Locator;
use Deployee\Plugins\OxidEshopTasks\Shop\ShopConfig;

class DependencyProvider implements DependencyProviderInterface
{
    /**
     * @param Locator $locator
     */
    public function defineDependencies(Locator $locator)
    {
        $locator->Dependency()->setDependency(Module::SHOP_CONFIG_DEPENDENCY, function() use ($locator){
            if(!($shopPath = realpath($locator->Config()->get('oxid.path')))
                || !is_file($shopPath . '/config.inc.php')){
                throw new \InvalidArgumentException(sprintf("You must define the config var \"%s\"", "oxid.path"));
            }

            return new ShopConfig($shopPath . '/config.inc.php');
        });
    }

}