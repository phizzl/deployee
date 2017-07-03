<?php


namespace Phizzl\Deployee\Dispatcher;


use Phizzl\Deployee\Tasks\TaskInterface;

interface TaskDispatchResultInterface
{
    const STATUS_OK = 0;

    /**
     * @return TaskInterface
     */
    public function getTask();

    /**
     * @return string
     */
    public function getMessage();

    /**
     * @return int
     */
    public function getExitCode();
}