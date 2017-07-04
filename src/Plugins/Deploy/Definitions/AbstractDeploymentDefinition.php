<?php


namespace Phizzl\Deployee\Plugins\Deploy\Definitions;



use Phizzl\Deployee\Container;
use Phizzl\Deployee\Plugins\Deploy\Tasks\TaskHelper;
use Phizzl\Deployee\Tasks\TaskCollection;
use Phizzl\Deployee\Tasks\TaskInterface;

abstract class AbstractDeploymentDefinition implements DeploymentDefinitionInterface
{
    /**
     * @var TaskCollection
     */
    private $taskCollection;

    /**
     * @var Container
     */
    private $container;

    /**
     * AbstractDeploymentDefinition constructor.
     */
    public function __construct(Container $container)
    {
        $this->taskCollection = new TaskCollection();
        $this->container = $container;
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

    /**
     * @param string $name
     * @param array $arguments
     * @return TaskInterface
     */
    public function __call($name, $arguments)
    {
        $task = call_user_func_array([$this->container[TaskHelper::CONTAINER_ID], $name], $arguments);
        $this->addTask($task);
        return $task;
    }
}