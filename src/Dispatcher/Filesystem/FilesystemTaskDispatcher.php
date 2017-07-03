<?php

namespace Phizzl\Deployee\Dispatcher\Filesystem;


use Phizzl\Deployee\CollectionInterface;
use Phizzl\Deployee\Dispatcher\AbstractTaskDispatcher;
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
            'Phizzl\Deployee\Dispatcher\Filesystem\DirectoryTask'
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
            $this->handleDirectoryRemove($definition);
        }
    }

    /**
     * @param CollectionInterface $definition
     */
    private function handleDirectoryRemove(CollectionInterface $definition)
    {
        if($definition->offsetGet('recursive') === true){
            $recursiveDirectoryRemover = new RecursiveDirectoryRemover();
            $recursiveDirectoryRemover->remove($definition->offsetGet('path'));
        }
        elseif(rmdir($definition->offsetGet('path')) === false){
            throw new \RuntimeException(
                "Could not remove directory \"{$definition->offsetGet('path')}\". "
                . print_r(error_get_last(), true)
            );
        }
    }
}