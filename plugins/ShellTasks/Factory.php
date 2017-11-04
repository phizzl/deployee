<?php

namespace Deployee\Plugins\ShellTasks;

use Deployee\Kernel\Modules\AbstractFactory;
use Deployee\Plugins\ShellTasks\Helper\ExecutableFinder;

class Factory extends AbstractFactory
{
    /**
     * @return ExecutableFinder
     */
    public function createExecutableFinder()
    {
        return new ExecutableFinder();
    }
}