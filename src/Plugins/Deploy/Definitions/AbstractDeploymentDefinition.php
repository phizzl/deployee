<?php


namespace Phizzl\Deployee\Plugins\Deploy\Definitions;



use Phizzl\Deployee\Container;
use Phizzl\Deployee\Dispatcher\Filesystem\DirectoryTask;
use Phizzl\Deployee\Dispatcher\Filesystem\FileTask;
use Phizzl\Deployee\Dispatcher\Filesystem\PermissionsTask;
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
     * @param string $path
     * @return FileTask
     */
    protected function file($path)
    {
        $task = new FileTask($path);
        $this->addTask($task);
        return $task;
    }

    /**
     * @param string $path
     * @return DirectoryTask
     */
    protected function directory($path)
    {
        $task = new DirectoryTask($path);
        $this->addTask($task);
        return $task;
    }

    /**
     * @param string $path
     * @return PermissionsTask
     */
    protected function filePermissions($path)
    {
        $task = new PermissionsTask($path);
        $this->addTask($task);
        return $task;
    }

    /**
     * @param string $name
     * @param array $arguments
     * @return TaskInterface
     */
    public function __call($name, $arguments)
    {
        return call_user_func_array([$this->container[TaskHelper::CONTAINER_ID], $name], $arguments);
    }
}