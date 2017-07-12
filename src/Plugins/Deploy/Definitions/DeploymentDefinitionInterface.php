<?php


namespace Deployee\Plugins\Deploy\Definitions;

use Deployee\CollectionInterface;

interface DeploymentDefinitionInterface
{
    /**
     * Defines a deployment
     */
    public function define();

    /**
     * @return CollectionInterface
     */
    public function getTasks();
}