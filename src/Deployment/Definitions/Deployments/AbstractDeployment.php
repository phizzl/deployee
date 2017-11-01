<?php


namespace Deployee\Deployment\Definitions\Deployments;

use Deployee\Deployment\Definitions\Tasks\TaskDefinitionCollection;
use Deployee\Deployment\Definitions\Tasks\TaskDefinitionInterface;
use Deployee\Deployment\DeploymentModule;
use Deployee\Deployment\Helper\TaskCreationHelper;
use Deployee\Kernel\Locator;

abstract class AbstractDeployment implements DeploymentDefinitionInterface
{
    /**
     * @var TaskDefinitionCollection
     */
    private $tasks;

    /**
     * @var Locator
     */
    protected $locator;

    /**
     * AbstractDeployment constructor.
     */
    public function __construct()
    {
        $this->tasks = new TaskDefinitionCollection();
    }

    /**
     * @param TaskDefinitionInterface $task
     */
    public function addTask(TaskDefinitionInterface $task)
    {
        $this->tasks->addTaskDefinition($task);
    }

    /**
     * @return TaskDefinitionCollection
     */
    public function getTasks()
    {
        return $this->tasks;
    }

    /**
     * @param Locator $locator
     */
    public function setLocator(Locator $locator)
    {
        $this->locator = $locator;
    }

    /**
     * @param string $name
     * @param $arguments
     * @return TaskDefinitionInterface
     */
    public function __call($name, $arguments)
    {
        /* @var TaskCreationHelper $helper */
        $helper = $this->locator->Dependency()->getFacade()->getDependency(DeploymentModule::DEFINITION_HELPER_TASK_CREATION_DEPENDENCY);
        return $helper->createTask($name, $arguments);
    }
}