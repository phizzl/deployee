<?php

namespace Deployee\Plugins\ShopwareTasks\Definitions;


use Deployee\Deployment\Definitions\Parameter\ParameterCollection;
use Deployee\Deployment\Definitions\Tasks\AbstractTaskDefinition;

class GenerateAttributesDefinition extends AbstractTaskDefinition
{
    /**
     * @return ParameterCollection
     */
    public function define()
    {
        return new ParameterCollection();
    }
}