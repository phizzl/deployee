<?php

namespace Deployee\Application;



class Module extends \Deployee\Kernel\Modules\Module
{
    const APPLICATION_DEPENDENCY = "module.application";

    const COMMAND_COLLECTION_DEPENDENCY = "module.application.commandcollection";
}