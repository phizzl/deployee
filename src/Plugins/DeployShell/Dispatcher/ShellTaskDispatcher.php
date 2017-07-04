<?php

namespace Phizzl\Deployee\Plugins\DeployShell\Dispatcher;


use Phizzl\Deployee\Container;
use Phizzl\Deployee\Dispatcher\AbstractTaskDispatcher;
use Phizzl\Deployee\Plugins\DeployShell\Services\ExecutableFinderService;
use Phizzl\Deployee\Plugins\DeployShell\ShellCommand;
use Phizzl\Deployee\Plugins\DeployShell\ShellCommandFactory;
use Phizzl\Deployee\Tasks\TaskInterface;

class ShellTaskDispatcher extends AbstractTaskDispatcher
{
    /**
     * @var Container
     */
    private $container;

    /**
     * ShellTaskDispatcher constructor.
     * @param Container $container
     */
    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    /**
     * @return array
     */
    protected function getDispatchableClasses()
    {
        return [
            'Phizzl\Deployee\Plugins\DeployShell\Tasks\ShellTask'
        ];
    }

    /**
     * @param TaskInterface $task
     * @return int
     */
    protected function dispatchShellTask(TaskInterface $task)
    {
        $definition = $task->getDefinition();
        $executable = $this->container[ExecutableFinderService::CONTAINER_ID]->find($definition['executable']);
        $arguments = isset($definition['arguments']) ? $definition['arguments'] : '';

        /* @var ShellCommand $command */
        $commandStr = trim("$executable $arguments");

        $this->container->logger()->debug("Shell >> Dispatching Shell command: $commandStr");

        $command = $this->container[ShellCommandFactory::CONTAINER_ID]->create($commandStr);
        $return = $command->run();

        $this->container->logger()->debug("Shell >> Exit code is: " . $return['code']);

        if($return['code'] !== ShellCommand::EXIT_CODE_OK){
            throw new \RuntimeException("Failed executing shell task. " . print_r($return, true));
        }

        return 0;
    }
}