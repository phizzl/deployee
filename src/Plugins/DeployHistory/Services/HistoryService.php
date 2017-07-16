<?php

namespace Deployee\Plugins\DeployHistory\Services;


use Deployee\Plugins\Deploy\Definitions\DeploymentDefinitionInterface;
use Deployee\Plugins\DeployHistory\Storages\DefinitionStorageInterface;

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

    /**
     * @inheritdoc
     */
    public function setup()
    {
        $this->storage->setup();
    }
}