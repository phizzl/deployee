<?php


namespace Deployee\Plugins\FilesystemTasks\Dispatcher;


use Deployee\Deployment\Definitions\Tasks\TaskDefinitionInterface;
use Deployee\Plugins\FilesystemTasks\Definitions\DirectoryTaskDefinition;
use Deployee\Plugins\FilesystemTasks\Utils\RmDir;
use Deployee\Plugins\RunDeploy\Dispatcher\AbstractTaskDefinitionDispatcher;
use Deployee\Plugins\RunDeploy\Dispatcher\DispatchResult;

class DirectoryTaskDefinitionDispatcher extends AbstractTaskDefinitionDispatcher
{
    /**
     * @param TaskDefinitionInterface $taskDefinition
     * @return bool
     */
    public function canDispatchTaskDefinition(TaskDefinitionInterface $taskDefinition)
    {
        return $taskDefinition instanceof DirectoryTaskDefinition;
    }

    /**
     * @param TaskDefinitionInterface $taskDefinition
     * @return DispatchResult
     */
    public function dispatch(TaskDefinitionInterface $taskDefinition)
    {
        $definition = $taskDefinition->define();
        if($definition->get('create') === true){
            return $this->createDirectory($definition->get('path'), $definition->get('recursive'));
        }
        elseif($definition->get('remove') === true) {
            return $this->removeDiretory($definition->get('path'), $definition->get('recursive'));
        }

        throw new \LogicException("Invalid definition");
    }

    /**
     * @param string $directory
     * @param bool $recursive
     * @return DispatchResult
     */
    private function removeDiretory($directory, $recursive)
    {
        try{
            $rmDir = new RmDir();
            $rmDir->remove($directory, $recursive);
        }
        catch(\InvalidArgumentException $e){}
        catch(\RuntimeException $e){}

        return isset($e)
            ? new DispatchResult(
                255,
                '',
                sprintf("Could not remove directory %s", $directory) . PHP_EOL . print_r(error_get_last(), true)
            )
            : new DispatchResult(
                0,
                sprintf("Directory removed: %s", $directory)
            );
    }

    /**
     * @param string $directory
     * @param bool $recursive
     * @return DispatchResult
     */
    private function createDirectory($directory, $recursive)
    {
        if(!mkdir($directory, 0777, $recursive)){
            return new DispatchResult(
                255,
                '',
                sprintf("Could not create directory %s", $directory) . PHP_EOL . print_r(error_get_last(), true)
            );
        }

        return new DispatchResult(0, sprintf("Directory created: %s", $directory));
    }
}