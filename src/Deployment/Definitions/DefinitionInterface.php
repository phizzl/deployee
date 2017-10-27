<?php

namespace Deployee\Deployment\Definitions;

use Deployee\Deployment\Definitions\Parameter\ParameterCollectionInterface;
use Deployee\Kernel\LocatorAwareInterface;

interface DefinitionInterface extends LocatorAwareInterface
{
    /**
     * @return ParameterCollectionInterface
     */
    public function define();
}