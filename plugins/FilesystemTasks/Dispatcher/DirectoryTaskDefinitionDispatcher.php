<?php


namespace Deployee\Plugins\FilesystemTasks\Dispatcher;


use Deployee\Deployment\Definitions\Tasks\TaskDefinitionInterface;
use Deployee\Plugins\FilesystemTasks\Definitions\DirectoryTaskDefinition;
use Deployee\Plugins\FilesystemTasks\Utils\Rm;
use Deployee\Plugins\RunDeploy\Dispatcher\AbstractTaskDefinitionDispatcher;
use Deployee\Plugins\RunDeploy\Dispatcher\DispatchResult;

class DirectoryTaskDefinitionDispatcher extends AbstractTaskDefinitionDispatcher
{
    /**
     * @param TaskDefinitionInterface $taskDefinition
     * @return bool
     */
    public function canDispatchTaskDefinition(TaskDefinitionInterface $taskDefinition)
    {
        return $taskDefinition instanceof DirectoryTaskDefinition;
    }

    /**
     * @param TaskDefinitionInterface $taskDefinition
     * @return DispatchResult
     */
    public function dispatch(TaskDefinitionInterface $taskDefinition)
    {

    }
}