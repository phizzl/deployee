<?php

namespace Phizzl\Deployee\Plugins\DeployHistory\Services;


use Phizzl\Deployee\Plugins\Deploy\Definitions\DeploymentDefinitionInterface;
use Phizzl\Deployee\Plugins\DeployHistory\Storages\DefinitionStorageInterface;

class HistoryService
{
    const CONTAINER_ID = "plugin.deployhistory.services.history";

    /**
     * @var DefinitionStorageInterface
     */
    private $storage;

    /**
     * HistoryService constructor.
     * @param DefinitionStorageInterface $storage
     */
    public function __construct(DefinitionStorageInterface $storage)
    {
        $this->storage = $storage;
    }

    /**
     * @param DeploymentDefinitionInterface $definition
     * @return bool
     */
    public function isStored(DeploymentDefinitionInterface $definition)
    {
        return $this->storage->isStored($definition);
    }

    /**
     * @param DeploymentDefinitionInterface $definition
     */
    public function store(DeploymentDefinitionInterface $definition)
    {
        $this->storage->store($definition);
    }
}