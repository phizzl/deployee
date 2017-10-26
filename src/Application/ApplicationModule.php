<?php

namespace Deployee\Application;


use Deployee\Kernel\Modules\Module;

class ApplicationModule extends Module
{
    const APPLICATION_DEPENDENCY = "module.application";

    const COMMAND_COLLECTION_DEPENDENCY = "module.application.commandcollection";
}