<?php

namespace Phizzl\Deployee\Dispatcher\Filesystem;


use Phizzl\Deployee\Dispatcher\AbstractTaskDispatcher;
use Phizzl\Deployee\Tasks\TaskInterface;

class FilesystemTaskDispatcher extends AbstractTaskDispatcher
{
    /**
     * @return array
     */
    protected function getDispatchableClasses()
    {
        return [
            'Phizzl\Deployee\Dispatcher\Filesystem\CreateDirTask'
        ];
    }


    public function disptach(TaskInterface $task)
    {
        die(get_class($task));
    }

}