<?php


namespace Deployee\Plugins\FilesystemTasks\Dispatcher;


use Deployee\Deployment\Definitions\Tasks\TaskDefinitionInterface;
use Deployee\Plugins\FilesystemTasks\Definitions\FileTaskDefinition;
use Deployee\Plugins\FilesystemTasks\Utils\Rm;
use Deployee\Plugins\RunDeploy\Dispatcher\AbstractTaskDefinitionDispatcher;
use Deployee\Plugins\RunDeploy\Dispatcher\DispatchResult;

class FileTaskDefinitionDispatcher extends AbstractTaskDefinitionDispatcher
{
    /**
     * @param TaskDefinitionInterface $taskDefinition
     * @return bool
     */
    public function canDispatchTaskDefinition(TaskDefinitionInterface $taskDefinition)
    {
        return $taskDefinition instanceof FileTaskDefinition;
    }

    /**
     * @param TaskDefinitionInterface $taskDefinition
     * @return DispatchResult
     */
    public function dispatch(TaskDefinitionInterface $taskDefinition)
    {
        $definition = $taskDefinition->define();
        if($definition->get('remove') === true){
            return $this->removeFile($definition->get('path'));
        }

        if(strlen($definition->get('symlink')) > 0){
            return $this->createSymlink($definition->get('symlink'), $definition->get('path'));
        }

        if(strlen($definition->get('copy')) > 0) {
            return $this->copyFile($definition->get('copy'), $definition->get('path'));
        }

        return $this->setFileContents($definition->get('path'), $definition->get('contents'));
    }

    private function setFileContents($file, $contents)
    {
        if(($bytes = file_put_contents($file, $contents)) === false){
            return new DispatchResult(
                255,
                '',
                sprintf("Could not write to file %s", $file) . PHP_EOL . print_r(error_get_last(), true)
            );
        }

        return new DispatchResult(0, sprintf("Wrote %s bytes to %s", $bytes, $file));
    }

    /**
     * @param string $source
     * @param string $target
     * @return DispatchResult
     */
    private function copyFile($source, $target)
    {
        if (copy($source, $target) === false) {
            return new DispatchResult(
                255,
                '',
                sprintf("Could not copy file from %s to %s", $source, $target) . PHP_EOL .
                implode(PHP_EOL, error_get_last())
            );
        }

        return new DispatchResult(0, sprintf("Copied: %s -> %s", $source, $target));
    }

    /**
     * @param string $linkSource
     * @param string $linkTarget
     * @return DispatchResult
     */
    private function createSymlink($linkSource, $linkTarget)
    {
        if(symlink($linkSource, $linkTarget) === false){
            return new DispatchResult(
                255,
                '',
                sprintf("Could not create symlink from %s to %s", $linkSource, $linkTarget) . PHP_EOL .
                implode(PHP_EOL, error_get_last())
            );
        }

        return new DispatchResult(0, sprintf("Linked: %s -> %s", $linkSource, $linkTarget));
    }

    /**
     * @param string $path
     * @return DispatchResult
     */
    private function removeFile($path)
    {
        $rm = new Rm();
        try {
            $rm->remove($path);
            $return = new DispatchResult(0, sprintf("Removed: %s", $path));
        }
        catch(\RuntimeException $e){
            $return = new DispatchResult(255, '', $e->getMessage() . PHP_EOL . $e->getTraceAsString());
        }

        return $return;
    }
}