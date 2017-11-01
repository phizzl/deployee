<?php

namespace Deployee\Deployment;


class Module extends \Deployee\Kernel\Modules\Module
{
    const DEPLOYMENT_DEFINITION_FINDER_DEPENDENCY = "deployment.definitionfinder";

    const DEFINITION_HELPER_TASK_CREATION_DEPENDENCY = "deployment.taskcreation";
}