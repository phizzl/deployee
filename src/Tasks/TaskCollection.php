<?php

namespace Phizzl\Deployee\Tasks;

use Phizzl\Deployee\Collection;

class TaskCollection extends Collection implements TaskCollectionInterface
{
    /**
     * @param TaskInterface $task
     */
    public function add(TaskInterface $task)
    {
        $this[] = $task;
    }

    /**
     * @return $this
     */
    public function getTasks()
    {
        return $this;
    }
}