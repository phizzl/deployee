<?php


namespace Phizzl\Deployee\Plugins\Deploy\Definitions;



use Phizzl\Deployee\Tasks\TaskCollection;
use Phizzl\Deployee\Tasks\TaskInterface;

abstract class AbstractDeploymentDefinition implements DeploymentDefinitionInterface
{
    /**
     * @var TaskCollection
     */
    private $taskCollection;

    /**
     * AbstractDeploymentDefinition constructor.
     */
    public function __construct()
    {
        $this->taskCollection = new TaskCollection();
    }

    /**
     * @param TaskInterface $task
     */
    protected function addTask(TaskInterface $task)
    {
        $this->taskCollection->add($task);
    }

    /**
     * @return TaskCollection
     */
    public function getTasks()
    {
        return $this->taskCollection;
    }
}