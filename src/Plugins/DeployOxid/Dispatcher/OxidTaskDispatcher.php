<?php

namespace Deployee\Plugins\DeployOxid\Dispatcher;

use Deployee\Container;
use Deployee\Dispatcher\AbstractTaskDispatcher;
use Deployee\Plugins\DeployOxid\Tasks\ModuleTask;
use Deployee\Plugins\DeployShell\Tasks\ShellTask;
use Deployee\Tasks\TaskInterface;

class OxidTaskDispatcher extends AbstractTaskDispatcher
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
            'Deployee\Plugins\DeployOxid\Tasks\ModuleTask',
            'Deployee\Plugins\DeployOxid\Tasks\ShopTask'
        ];
    }

    /**
     * @param TaskInterface $task
     * @return int
     */
    protected function dispatchModuleTask(TaskInterface $task)
    {
        $definition = $task->getDefinition();
        $shellCommand = $definition['mode'] === ModuleTask::MODE_ACTIVATE
            ? "oxid:module:activate"
            : "oxid:module:deactivate";

        $shopIdOptions = "";
        foreach($definition['shopids'] as $shopId){
            $shopIdOptions .= "--shopid={$shopId}";
        }

        $shellTask = new ShellTask("oxid");
        $shellTask->arguments(trim("{$shellCommand} {$definition['moduleid']} {$shopIdOptions}"));

        $dispatcher = $this->container->taskDispatcher()->getDispatcherByTask($shellTask);

        return $dispatcher->dispatch($shellTask)->getExitCode();
    }

    /**
     * @param TaskInterface $task
     * @return int
     */
    protected function dispatchShopTask(TaskInterface $task)
    {
        $definition = $task->getDefinition();
        $return = 0;

        if($definition['cleartmp'] === true
            && ($exitCode = $this->executeClearTmp()) > 0){
            $return = $exitCode;
        }

        if($return === 0
            && $definition['generateviews'] === true
            && ($exitCode = $this->executeGenerateViews()) > 0){
            $return = $exitCode;
        }

        if($return === 0
            && count($definition['adminuser'])
            && ($exitCode = $this->executeCreateAdmin($definition['adminuser'])) > 0){
            $return = $exitCode;
        }

        return $return;
    }

    /**
     * @param array $adminUser
     * @return int
     */
    private function executeCreateAdmin(array $adminUser)
    {;
        foreach($adminUser as $user){
            $shellTask = new ShellTask("oxid");
            $shellTask->arguments(
                "oxid:user:create-admin " .
                escapeshellarg($user['username']) . " " .
                escapeshellarg($user['password'])
            );
            $dispatcher = $this->container->taskDispatcher()->getDispatcherByTask($shellTask);
            if($exitCode = $dispatcher->dispatch($shellTask)->getExitCode()){
                return $exitCode;
            }

        }
        return 0;
    }

    /**
     * @return int
     */
    private function executeGenerateViews()
    {
        $shellTask = new ShellTask("oxid");
        $shellTask->arguments("oxid:db:generate-views");

        $dispatcher = $this->container->taskDispatcher()->getDispatcherByTask($shellTask);
        return $dispatcher->dispatch($shellTask)->getExitCode();
    }

    /**
     * @return int
     */
    private function executeClearTmp()
    {
        $shellTask = new ShellTask("oxid");
        $shellTask->arguments("oxid:clear-tmp");

        $dispatcher = $this->container->taskDispatcher()->getDispatcherByTask($shellTask);
        return $dispatcher->dispatch($shellTask)->getExitCode();
    }
}