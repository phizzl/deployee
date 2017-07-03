<?php

namespace Phizzl\Deployee\Dispatcher;

use Phizzl\Deployee\Collection;

class TaskDispatcherCollection extends Collection
{
    const CONTAINER_ID = "deployee.tasks.dispatcher.collection";

    /**
     * @param TaskDispatcherInterface $dispatcher
     */
    public function registerDispatcher(TaskDispatcherInterface $dispatcher)
    {
        $this[] = $dispatcher;
    }

    /**
     * @param mixed $offset
     * @param mixed $value
     */
    public function offsetSet($offset, $value)
    {
        if(!$value instanceof TaskDispatcherInterface){
            throw new \InvalidArgumentException("Value must implement TaskDispatcherInterface");
        }

        parent::offsetSet($offset, $value);
    }
}