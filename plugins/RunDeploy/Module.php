<?php

namespace Deployee\Plugins\RunDeploy;


class Module extends \Deployee\Kernel\Modules\Module
{
    const DISPATCHER_COLLECTION_DEPENDENCY = "rundeploy.dependencycollection";

    const DISPATCHER_FINDER_DEPENDENCY = "rundeploy.dependencyfinder";
}