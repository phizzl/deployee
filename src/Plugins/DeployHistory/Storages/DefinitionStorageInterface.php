<?php


namespace Phizzl\Deployee\Plugins\DeployHistory\Storages;


use Phizzl\Deployee\Plugins\Deploy\Definitions\DeploymentDefinitionInterface;

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