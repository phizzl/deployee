<?php


namespace Phizzl\Deployee\Tasks;


class TaskResult implements TaskResultInterface
{
    /**
     * @var TaskInterface
     */
    private $task;

    /**
     * @var int
     */
    private $result;

    /**
     * @var array
     */
    private $logs;

    /**
     * @var array
     */
    private $errors;

    /**
     * TaskResult constructor.
     * @param TaskInterface $task
     * @param int $result
     * @param array $logs
     * @param array $errors
     */
    public function __construct(TaskInterface $task, $result, array $logs, array $errors)
    {
        $this->result = $result;
        $this->logs = $logs;
        $this->errors = $errors;
        $this->setTask($task);
    }

    /**
     * @param TaskInterface $task
     */
    public function setTask(TaskInterface $task)
    {
        $this->task = $task;
    }

    /**
     * @return int
     */
    public function getResult()
    {
        return $this->result;
    }

    /**
     * @return array
     */
    public function getLogs()
    {
        return $this->logs;
    }

    /**
     * @return array
     */
    public function getErrors()
    {
        return $this->errors;
    }
}