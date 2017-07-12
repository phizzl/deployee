<?php


namespace Deployee\Plugins\DeployHistory\Storages;


use Deployee\Plugins\Deploy\Definitions\DeploymentDefinitionInterface;

interface DefinitionStorageInterface
{
    /**
     * @param DeploymentDefinitionInterface $definition
     * @return bool
     */
    public function isStored(DeploymentDefinitionInterface $definition);

    /**
     * @param DeploymentDefinitionInterface $definition
     */
    public function store(DeploymentDefinitionInterface $definition);
}