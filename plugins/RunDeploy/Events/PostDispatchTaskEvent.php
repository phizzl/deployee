<?php

namespace Deployee\Plugins\RunDeploy\Events;


use Deployee\Deployment\Definitions\Tasks\TaskDefinitionInterface;
use Deployee\Events\AbstractEvent;
use Deployee\Plugins\RunDeploy\Dispatcher\DispatchResultInterface;

class PostDispatchTaskEvent extends AbstractEvent
{
    /**
     * @var TaskDefinitionInterface
     */
    private $task;

    /**
     * @var DispatchResultInterface
     */
    private $result;

    /**
     * PostDispatchTaskEvent constructor.
     * @param TaskDefinitionInterface $task
     * @param DispatchResultInterface $result
     */
    public function __construct(TaskDefinitionInterface $task, DispatchResultInterface $result)
    {
        $this->task = $task;
        $this->result = $result;
    }

    /**
     * @return TaskDefinitionInterface
     */
    public function getTask()
    {
        return $this->task;
    }

    /**
     * @return DispatchResultInterface
     */
    public function getResult()
    {
        return $this->result;
    }
}