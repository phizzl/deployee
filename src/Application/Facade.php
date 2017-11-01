<?php

namespace Deployee\Application;

use Deployee\Kernel\Modules\AbstractFacade;

class Facade extends AbstractFacade
{
    public function runApplication()
    {
        $this->locator->Application()->getFactory()->createApplication()->run();
    }
}