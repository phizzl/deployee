<?php

namespace Deployee\Deployment;


use Deployee\Kernel\Modules\Module;

class DeploymentModule extends Module
{
    const DEPLOYMENT_DEFINITION_FINDER_DEPENDENCY = "deployment.definitionfinder";

    const DEFINITION_HELPER_TASK_CREATION_DEPENDENCY = "deployment.taskcreation";
}