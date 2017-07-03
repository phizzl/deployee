<?php


namespace Phizzl\Deployee\Plugins\Deploy\Definitions;

use Phizzl\Deployee\CollectionInterface;

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