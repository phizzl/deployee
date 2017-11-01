<?php

namespace Deployee\Plugins\RunDeploy\Events;


use Deployee\Deployment\Definitions\Tasks\TaskDefinitionInterface;
use Deployee\Events\AbstractEvent;

class PreDispatchTaskEvent extends AbstractEvent
{
    /**
     * @var TaskDefinitionInterface
     */
    private $task;

    /**
     * @var bool
     */
    private $preventDispatch;

    /**
     * PreDispatchTaskEvent constructor.
     * @param TaskDefinitionInterface $task
     */
    public function __construct(TaskDefinitionInterface $task)
    {
        $this->task = $task;
        $this->preventDispatch = false;
    }

    /**
     * @return TaskDefinitionInterface
     */
    public function getTask()
    {
        return $this->task;
    }

    /**
     * @return bool
     */
    public function isPreventDispatch()
    {
        return $this->preventDispatch;
    }

    /**
     * @param bool $preventDispatch
     */
    public function setPreventDispatch($preventDispatch)
    {
        $this->preventDispatch = $preventDispatch;
    }
}