<?php


namespace Phizzl\Deployee\Plugins\DeployDb\Dispatcher;

use Phizzl\Deployee\Container;
use Phizzl\Deployee\Dispatcher\AbstractTaskDispatcher;
use Phizzl\Deployee\Plugins\DeployDb\DeployDbPlugin;
use Phizzl\Deployee\Plugins\DeployShell\Services\ExecutableFinderService;
use Phizzl\Deployee\Plugins\DeployShell\Tasks\ShellTask;
use Phizzl\Deployee\Tasks\TaskInterface;
use Phizzl\MySql\MySqlDumpDefinition;

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
        $pluginConfig = $this->container->plugins()->offsetGet(DeployDbPlugin::PLUGIN_ID)->getConfig();
        /* @var ExecutableFinderService $executableFinder */
        $executableFinder = $this->container[ExecutableFinderService::CONTAINER_ID];
        $mysqldumpBin = $executableFinder->find('mysqldump');
        $mysqlBin = $executableFinder->find("mysql");

        $mysqldump = new MySqlDumpDefinition($pluginConfig['name'], $definition['target']);
        $mysqldump
            ->mysqldumpBin($mysqldumpBin)
            ->mysqlBin($mysqlBin)
            ->user($pluginConfig['user'])
            ->password($pluginConfig['password'])
            ->host($pluginConfig['host'])
            ->port($pluginConfig['port']);

        if($definition['force'] === true){
            $mysqldump->force();
        }

        if($definition['nocreateinfo'] === true){
            $mysqldump->noCreateInfo();
        }

        if($definition['nodata'] === true){
            $mysqldump->noData();
        }

        if(count($definition['includetables'])){
            $mysqldump
                ->dumpModeInclude()
                ->addTables($definition['includetables']);
        }

        if(count($definition['excludetables'])){
            $mysqldump
                ->dumpModeExclude()
                ->addTables($definition['excludetables']);
        }

        if(count($definition['excludetables'])
            && count($definition['includetables'])){
            throw new \LogicException("You cannot define exclude and include tables in one task");
        }

        $shellTask = new ShellTask("");
        $shellTask->arguments($mysqldump->getShellCommand());

        return $this->container->taskDispatcher()->getDispatcherByTask($shellTask)->disptach($shellTask)->getExitCode();
    }
}