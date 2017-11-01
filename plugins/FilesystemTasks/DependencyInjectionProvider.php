<?php

namespace Deployee\Plugins\FilesystemTasks;


use Deployee\Dependency\DependencyInjectionProviderInterface;
use Deployee\Deployment\Helper\TaskCreationHelper;
use Deployee\Deployment\Module;
use Deployee\Kernel\Locator;
use Deployee\Plugins\RunDeploy\Dispatcher\DispatcherCollection;

class DependencyInjectionProvider implements DependencyInjectionProviderInterface
{
    public function injectDependencies(Locator $locator)
    {
        $locator->Dependency()->extendDependency(Module::DEFINITION_HELPER_TASK_CREATION_DEPENDENCY, function(TaskCreationHelper $helper){
            $helper->addAlias('directory', 'Deployee\Plugins\FilesystemTasks\Definitions\DirectoryTaskDefinition');
            $helper->addAlias('file', 'Deployee\Plugins\FilesystemTasks\Definitions\FileTaskDefinition');
            return $helper;
        });

        $locator->Dependency()->extendDependency(\Deployee\Plugins\RunDeploy\Module::DISPATCHER_COLLECTION_DEPENDENCY, function(DispatcherCollection $collection) use($locator){
            $collection->addDispatcher(
                $locator->RunDeploy()->getFactory()->createDispatcher('Deployee\Plugins\FilesystemTasks\Dispatcher\DirectoryTaskDefinitionDispatcher')
            );

            $collection->addDispatcher(
                $locator->RunDeploy()->getFactory()->createDispatcher('Deployee\Plugins\FilesystemTasks\Dispatcher\FileTaskDefinitionDispatcher')
            );

            $collection->addDispatcher(
                $locator->RunDeploy()->getFactory()->createDispatcher('Deployee\Plugins\FilesystemTasks\Dispatcher\PermissionsTaskDefinitionDispatcher')
            );

            return $collection;
        });
    }

}