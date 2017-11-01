<?php

namespace Deployee\Plugins\RunDeploy;


use Deployee\Kernel\Modules\AbstractFactory;
use Deployee\Plugins\RunDeploy\Dispatcher\DispatcherCollection;
use Deployee\Plugins\RunDeploy\Dispatcher\DispatcherFinder;

class Factory extends AbstractFactory
{
    /**
     * @return DispatcherCollection
     */
    public function createDispatcherCollection()
    {
        return new DispatcherCollection();
    }

    /**
     * @return DispatcherFinder
     */
    public function createDispatcherFinder()
    {
        return new DispatcherFinder($this->locator);
    }
}