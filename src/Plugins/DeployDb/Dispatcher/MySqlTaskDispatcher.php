<?php


namespace Phizzl\Deployee\Plugins\DeployDb\Dispatcher;

use Phizzl\Deployee\Container;
use Phizzl\Deployee\Dispatcher\AbstractTaskDispatcher;
use Phizzl\Deployee\Plugins\DeployShell\Tasks\ShellTask;
use Phizzl\Deployee\Tasks\TaskInterface;

class MySqlTaskDispatcher extends AbstractTaskDispatcher
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
            'Phizzl\Deployee\Plugins\DeployDb\Tasks\MySqlDumpTask'
        ];
    }

    /**
     * @param TaskInterface $task
     * @return int
     */
    public function dispatchMySqlDumpTask(TaskInterface $task)
    {
        $definition = $task->getDefinition();
        $shellTask = new ShellTask("mysqldump");
        $shellTask->arguments("{$definition['arguments']} > {$definition['target']}");

        return $this->container->taskDispatcher()->getDispatcherByTask($shellTask)->disptach($shellTask)->getExitCode();
    }
}