<?php

namespace Phizzl\Deployee\Dispatcher\Filesystem;

use Phizzl\Deployee\Dispatcher\AbstractTaskDispatcher;
use Phizzl\Deployee\Dispatcher\Filesystem\Utils\RmDir;
use Phizzl\Deployee\Dispatcher\TaskDispatchException;
use Phizzl\Deployee\Dispatcher\TaskDispatchResultInterface;
use Phizzl\Deployee\Tasks\TaskInterface;

class FilesystemTaskDispatcher extends AbstractTaskDispatcher
{
    /**
     * @return array
     */
    protected function getDispatchableClasses()
    {
        return [
            'Phizzl\Deployee\Dispatcher\Filesystem\DirectoryTask',
            'Phizzl\Deployee\Dispatcher\Filesystem\FilePermissionsTask'
        ];
    }

    /**
     * @param TaskInterface $task
     * @return TaskDispatchResultInterface
     */
    public function disptach(TaskInterface $task)
    {
        $dispatchMethod = "dispatch" . basename(get_class($task));
        return call_user_func_array([$this, $dispatchMethod], [$task]);
    }

    private function dispatchFilePermissionsTask(TaskInterface $task)
    {
        $definition = $task->getDefinition();
    }

    /**
     * @param TaskInterface $task
     * @used-by FilesystemTaskDispatcher::dispatch
     */
    private function dispatchDirectoryTask(TaskInterface $task)
    {
        $definition = $task->getDefinition();
        if($definition->offsetGet('create') === true
            && !mkdir($definition->offsetGet('path'), 0777, $definition->offsetGet('recursive'))){
            throw new TaskDispatchException(
                "Could not create directory \"{$definition->offsetGet('path')}\". "
                . print_r(error_get_last(), true)
            );
        }
        elseif($definition->offsetGet('remove') === true) {
            $rmDir = new RmDir();
            $rmDir->remove($definition->offsetGet('path'), $definition->offsetGet('recursive'));
        }
    }
}