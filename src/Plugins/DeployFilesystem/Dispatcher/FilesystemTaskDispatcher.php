<?php

namespace Deployee\Plugins\DeployFilesystem\Dispatcher;

use Deployee\Dispatcher\AbstractTaskDispatcher;
use Deployee\Plugins\DeployFilesystem\Utils\Chmod;
use Deployee\Plugins\DeployFilesystem\Utils\Rm;
use Deployee\Plugins\DeployFilesystem\Utils\RmDir;
use Deployee\Dispatcher\TaskDispatchException;
use Deployee\Tasks\TaskInterface;

class FilesystemTaskDispatcher extends AbstractTaskDispatcher
{
    /**
     * @return array
     */
    protected function getDispatchableClasses()
    {
        return [
            'Deployee\Plugins\DeployFilesystem\Tasks\DirectoryTask',
            'Deployee\Plugins\DeployFilesystem\Tasks\PermissionsTask',
            'Deployee\Plugins\DeployFilesystem\Tasks\FileTask'
        ];
    }

    /**
     * @param TaskInterface $task
     * @return int
     */
    public function dispatchFileTask(TaskInterface $task)
    {
        $definition = $task->getDefinition();
        if($definition->offsetGet('remove') === true){
            $rm = new Rm();
            $rm->remove($definition->offsetGet('path'));
            return 0;
        }

        if(strlen($definition->offsetGet('copy')) > 0) {
            if (copy($definition->offsetGet('copy'), $definition->offsetGet('path')) === false) {
                throw new \RuntimeException(
                    "Could not copy file \"{$definition->offsetGet('copy')}\" to \"{$definition->offsetGet('path')}\""
                );
            }
            return 0;
        }

        if(file_put_contents($definition->offsetGet('path'), $definition->offsetGet('contents')) === false){
            throw new \RuntimeException("Could not write to file \"{$definition->offsetGet('path')}\"");
        }

        return 0;
    }

    /**
     * @param TaskInterface $task
     */
    public function dispatchFilePermissionsTask(TaskInterface $task)
    {
        $definition = $task->getDefinition();
        if($definition->offsetGet('permissions')){
            $chmod = new Chmod();
            $chmod->chmod($definition->offsetGet('path'), $definition->offsetGet('recursive'));
        }

        return 0;
    }

    /**
     * @param TaskInterface $task
     * @used-by FilesystemTaskDispatcher::dispatch
     */
    public function dispatchDirectoryTask(TaskInterface $task)
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

        return 0;
    }
}