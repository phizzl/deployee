<?php

namespace Deployee\Application;

use Deployee\Kernel\Modules\AbstractFacade;

class ApplicationFacade extends AbstractFacade
{
    public function runApplication()
    {
        $this->locator->Application()->getFactory()->createApplication()->run();
    }
}