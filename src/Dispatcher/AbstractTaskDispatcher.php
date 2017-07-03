<?php

namespace Phizzl\Deployee\Dispatcher;


use Phizzl\Deployee\Tasks\TaskInterface;

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
}