<?php

namespace Deployee\Deployment\Definitions\Tasks;


use Deployee\Deployment\Definitions\DefinitionInterface;
use Deployee\Deployment\Definitions\Parameter\ParameterCollectionInterface;

interface TaskDefinitionInterface extends DefinitionInterface
{
    /**
     * @return ParameterCollectionInterface
     */
    public function define();
}