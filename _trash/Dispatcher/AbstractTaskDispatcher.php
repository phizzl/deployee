<?php

namespace Deployee\Dispatcher;


use Deployee\Tasks\TaskInterface;

abstract class AbstractTaskDispatcher implements TaskDispatcherInterface
{
    /**
     * @return array
     */
    abstract protected function getDispatchableClasses();

    /**
     * @param TaskInterface $task
     * @return bool
     */
    public function canDispatch(TaskInterface $task)
    {
        return in_array(get_class($task), $this->getDispatchableClasses());
    }

    /**
     * @param TaskInterface $task
     * @return TaskDispatchResult
     */
    public function dispatch(TaskInterface $task)
    {
        $dispatchMethod = "dispatch" . basename(str_replace("\\", DIRECTORY_SEPARATOR, get_class($task)));
        $message = '';

        try {
            $exitCode = call_user_func_array([$this, $dispatchMethod], [$task]);
        }
        catch(\Exception $e){
            $exitCode = $e->getCode() ? $e->getCode() : 255;
            $message = $e->getMessage();
        }

        return new TaskDispatchResult($task, $message, $exitCode);
    }
}