<?php

namespace Phizzl\Deployee\Tasks;


interface TaskCollectionInterface
{
    /**
     * @param TaskInterface $task
     */
    public function add(TaskInterface $task);

    /**
     * @return array|\Traversable
     */
    public function getTasks();
}