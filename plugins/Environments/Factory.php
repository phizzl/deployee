<?php

namespace Deployee\Plugins\Environments;


use Deployee\Kernel\Modules\AbstractFactory;

class Factory extends AbstractFactory
{
    /**
     * @param string $name
     * @return Environment
     */
    public function createEnvironment($name)
    {
        return new Environment($name);
    }
}