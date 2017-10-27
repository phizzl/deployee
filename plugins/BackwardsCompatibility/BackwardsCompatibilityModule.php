<?php


namespace Deployee\Plugins\BackwardsCompatibility;


use Deployee\Kernel\Modules\Module;

class BackwardsCompatibilityModule extends Module
{
    public function onLoad()
    {
        if(!class_exists('\Deployee\Plugins\Deploy\Definitions\AbstractDeploymentDefinition')){
            class_alias(
                '\Deployee\Deployment\Definitions\Deployments\AbstractDeployment',
                '\Deployee\Plugins\Deploy\Definitions\AbstractDeploymentDefinition'
            );
        }
    }
}