<?php


namespace Phizzl\Deployee\Plugins\DeployOxid\Subscriber;



use Phizzl\Deployee\Events\BootstrapFinishedEvent;
use Phizzl\Deployee\Events\PluginsInitializedEvent;
use Phizzl\Deployee\Events\TaskDispatcherCollectionInitializedEvent;
use Phizzl\Deployee\Plugins\Deploy\Events\TaskHelperCreatedEvent;
use Phizzl\Deployee\Plugins\DeployOxid\DeployOxidPlugin;
use Phizzl\Deployee\Plugins\DeployOxid\Dispatcher\OxidTaskDispatcher;
use Phizzl\Deployee\Plugins\DeployShell\Services\ExecutableFinderService;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class DeployOxidSubscriber implements EventSubscriberInterface
{
    /**
     * @return array
     */
    public static function getSubscribedEvents()
    {
        return [
            BootstrapFinishedEvent::EVENT_NAME => 'onBootstrapFinished',
            TaskHelperCreatedEvent::EVENT_NAME => 'onTaskHelperCreated',
            TaskDispatcherCollectionInitializedEvent::EVENT_NAME => 'onTaskDispatcherCollectionInitialized'
        ];
    }

    /**
     * @param PluginsInitializedEvent $event
     */
    public function onBootstrapFinished(BootstrapFinishedEvent $event)
    {
        $config = $event->getContainer()->plugins()->offsetGet(DeployOxidPlugin::PLUGIN_ID)->getConfig();
        $container = $event->getContainer();

        $oxidConsole = isset($config['console_path'])
            ? $config['console_path']
            : getcwd() . '/vendor/bin/oxid';

        $container[ExecutableFinderService::CONTAINER_ID]->addAlias("oxid", $oxidConsole);
        return;
    }

    /**
     * @param TaskHelperCreatedEvent $event
     */
    public function onTaskHelperCreated(TaskHelperCreatedEvent $event)
    {
        $taskHelper = $event->getTaskHelper();
        $taskHelper->registerTask('Phizzl\Deployee\Plugins\DeployOxid\Tasks\ModuleTask', 'oxmodule');
    }

    /**
     * @param TaskDispatcherCollectionInitializedEvent $event
     */
    public function onTaskDispatcherCollectionInitialized(TaskDispatcherCollectionInitializedEvent $event)
    {
        $collection = $event->getTaskDispatcherCollection();
        $collection->registerDispatcher(new OxidTaskDispatcher($event->getContainer()));
    }
}