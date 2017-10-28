<?php

namespace Deployee\Plugins\BackwardsCompatibility\Dependency;


use Deployee\Dependency\DependencyInjectionProviderInterface;
use Deployee\Kernel\Locator;

class BackwardsCompatibilityDependencyInjectionProvider implements DependencyInjectionProviderInterface
{
    public function injectDependencies(Locator $locator)
    {
        if(!class_exists('\Deployee\Plugins\Deploy\Definitions\AbstractDeploymentDefinition')){
            class_alias(
                '\Deployee\Deployment\Definitions\Deployments\AbstractDeployment',
                '\Deployee\Plugins\Deploy\Definitions\AbstractDeploymentDefinition'
            );
        }
    }
}