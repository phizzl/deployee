<?php

namespace Deployee\Plugins\DeployShopware\Dispatcher;

use Deployee\Container;
use Deployee\Dispatcher\AbstractTaskDispatcher;
use Deployee\Plugins\DeployShopware\Tasks\CreateAdminTask;
use Deployee\Plugins\DeployShell\Tasks\ShellTask;

class CreateAdminTaskDispatcher extends AbstractTaskDispatcher
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
        return ['Deployee\Plugins\DeployShopware\Tasks\CreateAdminTask'];
    }

    /**
     * @param CreateAdminTask $task
     */
    protected function dispatchCreateAdminTask(CreateAdminTask $task)
    {
        $definition = $task->getDefinition();
        $shellTask = new ShellTask('shopware');
        $shellTask->arguments(
            "sw:admin:create" .
            " --email=" . escapeshellarg($definition['email']) .
            " --username=" . escapeshellarg($definition['username']) .
            " --name=" . escapeshellarg($definition['fullname']) .
            " --locale=" . escapeshellarg($definition['locale']) .
            " --password=" . escapeshellarg($definition['password']) .
            " --no-interaction"
        );

        $dispatcher = $this->container->taskDispatcher()->getDispatcherByTask($shellTask);

        return $dispatcher->dispatch($shellTask)->getExitCode();
    }
}