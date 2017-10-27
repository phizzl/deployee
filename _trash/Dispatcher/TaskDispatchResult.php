<?php


namespace Deployee\Dispatcher;


use Deployee\Tasks\TaskInterface;

class TaskDispatchResult implements TaskDispatchResultInterface
{
    /**
     * @var TaskInterface
     */
    private $task;

    /**
     * @var string
     */
    private $message;

    /**
     * @var int
     */
    private $exitCode;

    /**
     * TaskDispatchResult constructor.
     * @param TaskInterface $task
     * @param string $message
     * @param int $exitCode
     */
    public function __construct(TaskInterface $task, $message, $exitCode)
    {
        $this->task = $task;
        $this->message = $message;
        $this->exitCode = $exitCode;
    }

    /**
     * @return TaskInterface
     */
    public function getTask()
    {
        return $this->task;
    }

    /**
     * @return string
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * @return int
     */
    public function getExitCode()
    {
        return $this->exitCode;
    }
}