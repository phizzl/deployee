<?php


namespace Deployee\Plugins\ShellTasks\Dispatcher;


use Deployee\Deployment\Definitions\Tasks\TaskDefinitionInterface;
use Deployee\Plugins\RunDeploy\Dispatcher\AbstractTaskDefinitionDispatcher;
use Deployee\Plugins\RunDeploy\Dispatcher\DispatchResult;
use Deployee\Plugins\ShellTasks\Definitions\ShellTaskDefinition;
use Deployee\Plugins\ShellTasks\Helper\ExecutableFinder;
use Deployee\Plugins\ShellTasks\Module;
use Phizzl\PhpShellCommand\ShellCommand;

class ShellTaskDefinitionDispatcher extends AbstractTaskDefinitionDispatcher
{
    /**
     * @param TaskDefinitionInterface $taskDefinition
     * @return bool
     */
    public function canDispatchTaskDefinition(TaskDefinitionInterface $taskDefinition)
    {
        return $taskDefinition instanceof ShellTaskDefinition;
    }

    /**
     * @param TaskDefinitionInterface $taskDefinition
     * @return DispatchResult
     */
    public function dispatch(TaskDefinitionInterface $taskDefinition)
    {
        $definition = $taskDefinition->define();
        /* @var ExecutableFinder $executableFinder */
        $executableFinder = $this->locator->Dependency()->getDependency(Module::EXECUTABLE_FINDER_DEPENDENCY);
        $executable = $executableFinder->find($definition->get('executable'));
            //$this->container[ExecutableFinderService::CONTAINER_ID]->find($definition['executable']);
        $arguments = (string)$definition->get('arguments');

        $cmd = new ShellCommand("$executable $arguments");
        $return = $cmd->run();

        return $return->getExitCode() > 0
            ? new DispatchResult(
                $return->getExitCode(),
                $return->getOutput(),
                sprintf("Error executing: %s (%s)" . PHP_EOL . "%s", $cmd->getCommand(), $return->getExecTime(), $return->getError())
            )
            : new DispatchResult(
                $return->getExitCode(),
                sprintf("Executed command: %s (%s)" . PHP_EOL . "%s", $cmd->getCommand(), $return->getExitCode(), $return->getOutput())
            );
    }
}