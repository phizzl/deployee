<?php

namespace Deployee\Application;

use Deployee\Kernel\Modules\AbstractFacade;

class ApplicationFacade extends AbstractFacade
{
    /**
     * @var ApplicationFactory
     */
    protected $factory;

    public function runApplication()
    {
        $this->factory->createApplication()->run();
    }
}