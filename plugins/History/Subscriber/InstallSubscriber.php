<?php


namespace Deployee\Plugins\History\Subscriber;


use Deployee\Deployment\Definitions\Tasks\TaskDefinitionInterface;
use Deployee\Kernel\Locator;
use Deployee\Plugins\MySqlTasks\Definitions\MySqlFileDefinition;
use Deployee\Plugins\RunDeploy\Dispatcher\TaskDefinitionDispatcherInterface;
use Deployee\Plugins\RunDeploy\Events\RunInstallCommandEvent;
use Deployee\Plugins\RunDeploy\Module;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class InstallSubscriber implements EventSubscriberInterface
{
    /**
     * @var Locator
     */
    private $locator;

    /**
     * InstallSubscriber constructor.
     * @param Locator $locator
     */
    public function __construct(Locator $locator)
    {
        $this->locator = $locator;
    }

    /**
     * @return array
     */
    public static function getSubscribedEvents()
    {
        return [
            RunInstallCommandEvent::class => 'onInstall'
        ];
    }

    /**
     * @param RunInstallCommandEvent $event
     */
    public function onInstall(RunInstallCommandEvent $event)
    {
        $mysqlTask = new MySqlFileDefinition(__DIR__ . '/../install/install.sql');
        $dispatcherCollection = $this->locator->Dependency()->getDependency(Module::DISPATCHER_COLLECTION_DEPENDENCY);

        /* @var TaskDefinitionDispatcherInterface $dispatcher */
        foreach($dispatcherCollection->toArray() as $dispatcher){
            if($dispatcher->canDispatchTaskDefinition($mysqlTask)){
                $this->dispatchMysqlTask($dispatcher, $mysqlTask);
                return;
            }
        }

        throw new \LogicException("No dispatcher for MySQL installation found");
    }

    /**
     * @param TaskDefinitionDispatcherInterface $dispatcher
     * @param MySqlFileDefinition $taskDefinition
     */
    private function dispatchMysqlTask(TaskDefinitionDispatcherInterface $dispatcher, MySqlFileDefinition $taskDefinition)
    {
        $result = $dispatcher->dispatch($taskDefinition);
        if($result->getExitCode() > 0){
            throw new \RuntimeException("Install failed!");
        }
    }
}