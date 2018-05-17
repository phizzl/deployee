<?php

namespace Deployee\Plugins\ShopwareTasks;


use Deployee\Dependency\DependencyInjectionProviderInterface;
use Deployee\Deployment\Helper\TaskCreationHelper;
use Deployee\Kernel\Locator;
use Deployee\Plugins\MySqlTasks\Helper\Credentials;
use Deployee\Plugins\RunDeploy\Dispatcher\DispatcherCollection;
use Deployee\Plugins\ShopwareTasks\Shop\ShopConfig;

class DependencyInjectionProvider implements DependencyInjectionProviderInterface
{
    /**
     * @param Locator $locator
     */
    public function injectDependencies(Locator $locator)
    {
        if($locator->Config()->getFacade()->get('shopware.path')){
            $this->extendDbConfigDependency($locator);
        }

        $locator->Dependency()->getFacade()->extendDependency(\Deployee\Deployment\Module::DEFINITION_HELPER_TASK_CREATION_DEPENDENCY, function(TaskCreationHelper $helper){
            $helper->addAlias('swCreateAdminUser', 'Deployee\Plugins\ShopwareTasks\Definitions\CreateAdminUserDefinition');
            $helper->addAlias('swCacheClear', 'Deployee\Plugins\ShopwareTasks\Definitions\CacheClearDefinition');
            $helper->addAlias('swGenerateAttributes', 'Deployee\Plugins\ShopwareTasks\Definitions\GenerateAttributesDefinition');
            $helper->addAlias('swPluginInstall', 'Deployee\Plugins\ShopwareTasks\Definitions\PluginInstallDefinition');
            $helper->addAlias('swPluginReinstall', 'Deployee\Plugins\ShopwareTasks\Definitions\PluginReinstallDefinition');
            $helper->addAlias('swPluginUninstall', 'Deployee\Plugins\ShopwareTasks\Definitions\PluginUninstallDefinition');
            $helper->addAlias('swPluginUpdate', 'Deployee\Plugins\ShopwareTasks\Definitions\PluginUpdateDefinition');
            $helper->addAlias('swPluginActivate', 'Deployee\Plugins\ShopwareTasks\Definitions\PluginActivateDefinition');
            $helper->addAlias('swPluginDeactivate', 'Deployee\Plugins\ShopwareTasks\Definitions\PluginDeactivateDefinition');
            $helper->addAlias('swGenerateThemeCache', 'Deployee\Plugins\ShopwareTasks\Definitions\GenerateThemeCacheDefinition');
            $helper->addAlias('swCommand', 'Deployee\Plugins\ShopwareTasks\Definitions\ShopwareCommandDefinition');
            return $helper;
        });

        $locator->Dependency()->getFacade()->extendDependency(\Deployee\Plugins\RunDeploy\Module::DISPATCHER_COLLECTION_DEPENDENCY, function(DispatcherCollection $collection) use($locator){
            $addDispatcher = [
                'Deployee\Plugins\ShopwareTasks\Dispatcher\CreateAdminUserDispatcher',
                'Deployee\Plugins\ShopwareTasks\Dispatcher\CacheClearDispatcher',
                'Deployee\Plugins\ShopwareTasks\Dispatcher\GenerateAttributesDispatcher',
                'Deployee\Plugins\ShopwareTasks\Dispatcher\PluginInstallDispatcher',
                'Deployee\Plugins\ShopwareTasks\Dispatcher\PluginReinstallDispatcher',
                'Deployee\Plugins\ShopwareTasks\Dispatcher\PluginUninstallDispatcher',
                'Deployee\Plugins\ShopwareTasks\Dispatcher\PluginUpdateDispatcher',
                'Deployee\Plugins\ShopwareTasks\Dispatcher\PluginActivateDispatcher',
                'Deployee\Plugins\ShopwareTasks\Dispatcher\PluginDeactivateDispatcher',
                'Deployee\Plugins\ShopwareTasks\Dispatcher\GenerateThemeCacheDispatcher',
                'Deployee\Plugins\ShopwareTasks\Dispatcher\ShopwareCommandDispatcher',
            ];

            foreach($addDispatcher as $dispatcherClass){
                $collection->addDispatcher(
                    $locator->RunDeploy()->getFactory()->createDispatcher($dispatcherClass)
                );
            }

            return $collection;
        });
    }

    /**
     * @param Locator $locator
     */
    private function extendDbConfigDependency(Locator $locator)
    {
        $locator->Dependency()->getFacade()->extendDependency(\Deployee\Plugins\MySqlTasks\Module::CREDENTIALS_DEPENDENCY, function(Credentials $credentials) use($locator){
            /* @var ShopConfig $shopConfig */
            $shopConfig = $locator->Dependency()->getFacade()->getDependency(Module::SHOP_CONFIG_DEPENDENCY);
            $dbConfig = $shopConfig->get('db');

            $credentials->setDatabase($dbConfig['dbname']);
            $credentials->setUsername($dbConfig['username']);
            $credentials->setPassword($dbConfig['password']);
            $credentials->setHost($dbConfig['host']);
            $credentials->setPort((int)$dbConfig['port']);

            return $credentials;
        });
    }
}