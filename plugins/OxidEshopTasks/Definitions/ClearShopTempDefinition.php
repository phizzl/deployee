<?php

namespace Deployee\Plugins\OxidEshopTasks\Definitions;


use Deployee\Deployment\Definitions\Parameter\ParameterCollection;
use Deployee\Deployment\Definitions\Tasks\AbstractTaskDefinition;

class ClearShopTempDefinition extends AbstractTaskDefinition
{
    /**
     * @return ParameterCollection
     */
    public function define()
    {
        return new ParameterCollection();
    }
}