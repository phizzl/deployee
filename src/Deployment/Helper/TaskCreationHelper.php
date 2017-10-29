<?php

namespace Deployee\Deployment\Helper;


use Deployee\Deployment\Definitions\Tasks\TaskDefinitionInterface;
use Deployee\Kernel\Locator;

class TaskCreationHelper
{
    /**
     * @var Locator
     */
    private $locator;

    /**
     * @var array
     */
    private $alias;

    /**
     * TaskCreationHelper constructor.
     * @param Locator $locator
     */
    public function __construct(Locator $locator)
    {
        $this->alias = [];
        $this->locator = $locator;
    }

    /**
     * @param string $aliasName
     * @param string $className
     */
    public function addAlias($aliasName, $className)
    {
        $this->alias[$aliasName] = $className;
    }

    /**
     * @param string $aliasName
     * @param $arguments
     * @return TaskDefinitionInterface
     */
    public function createTask($aliasName, $arguments)
    {
        $className = isset($this->alias[$aliasName]) ? $this->alias[$aliasName] : $aliasName;
        return $this->locator->Deployment()->getFactory()->createTaskDefinition($className, $arguments);
    }
}