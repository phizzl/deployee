<?php

namespace Phizzl\Deployee\Dispatcher\Filesystem;

use Phizzl\Deployee\Dispatcher\AbstractTaskDispatcher;
use Phizzl\Deployee\Dispatcher\Filesystem\Utils\Chmod;
use Phizzl\Deployee\Dispatcher\Filesystem\Utils\Rm;
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
            'Phizzl\Deployee\Dispatcher\Filesystem\PermissionsTask',
            'Phizzl\Deployee\Dispatcher\Filesystem\FileTask'
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

    /**
     * @param TaskInterface $task
     */
    private function dispatchFileTask(TaskInterface $task)
    {
        $definition = $task->getDefinition();
        if($definition->offsetGet('remove') === true){
            $rm = new Rm();
            $rm->remove($definition->offsetGet('path'));
        }
        elseif(file_put_contents($definition->offsetGet('path'), $definition->offsetGet('contents')) === false){
            throw new \RuntimeException("Could not write to file \"{$definition->offsetGet('path')}\"");
        }
    }

    /**
     * @param TaskInterface $task
     */
    private function dispatchFilePermissionsTask(TaskInterface $task)
    {
        $definition = $task->getDefinition();
        if($definition->offsetGet('permissions')){
            $chmod = new Chmod();
            $chmod->chmod($definition->offsetGet('path'), $definition->offsetGet('recursive'));
        }
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