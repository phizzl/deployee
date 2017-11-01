<?php

namespace Deployee\Plugins\FilesystemTasks;


use Deployee\Dependency\DependencyInjectionProviderInterface;
use Deployee\Deployment\Helper\TaskCreationHelper;
use Deployee\Deployment\Module;
use Deployee\Kernel\Locator;

class DependencyInjectionProvider implements DependencyInjectionProviderInterface
{
    public function injectDependencies(Locator $locator)
    {
        $locator->Dependency()->extendDependency(Module::DEFINITION_HELPER_TASK_CREATION_DEPENDENCY, function(TaskCreationHelper $helper){
            $helper->addAlias('directory', 'Deployee\Plugins\FilesystemTasks\Definitions\DirectoryTaskDefinition');
            $helper->addAlias('file', 'Deployee\Plugins\FilesystemTasks\Definitions\FileTaskDefinition');
            return $helper;
        });
    }

}