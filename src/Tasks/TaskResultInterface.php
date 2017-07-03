<?php

namespace Phizzl\Deployee\Tasks;


interface TaskResultInterface
{
    const RESULT_SUCCESS = 1;

    const RESULT_FAILED = 0;

    /**
     * @param TaskInterface $task
     */
    public function setTask(TaskInterface $task);

    /**
     * Returns the current result status
     * @return int
     */
    public function getResult();

    /**
     * Get list of log messages
     * @return array|\Traversable
     */
    public function getLogs();

    /**
     * Get list of occured errors during the execution
     * @return array|\Traversable
     */
    public function getErrors();
}