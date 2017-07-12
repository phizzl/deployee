<?php


namespace Deployee\Plugins\DeployOxid\Subscriber;



use Deployee\Events\BootstrapFinishedEvent;
use Deployee\Events\PluginsInitializedEvent;
use Deployee\Events\TaskDispatcherCollectionInitializedEvent;
use Deployee\Plugins\Deploy\Events\TaskHelperCreatedEvent;
use Deployee\Plugins\DeployOxid\DeployOxidPlugin;
use Deployee\Plugins\DeployOxid\Dispatcher\OxidTaskDispatcher;
use Deployee\Plugins\DeployShell\Services\ExecutableFinderService;
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
        $taskHelper->registerTask('Deployee\Plugins\DeployOxid\Tasks\ModuleTask', 'module');
        $taskHelper->registerTask('Deployee\Plugins\DeployOxid\Tasks\ShopTask', 'shop');
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