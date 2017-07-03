<?php


namespace Phizzl\Deployee\Plugins\Deploy\Definitions;



use Phizzl\Deployee\Dispatcher\Filesystem\DirectoryTask;
use Phizzl\Deployee\Dispatcher\Filesystem\FileTask;
use Phizzl\Deployee\Dispatcher\Filesystem\PermissionsTask;
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
}