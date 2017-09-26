<?php


namespace Deployee\Plugins\DeployOxid\Subscriber;


use Deployee\Events\BootstrapFinishedEvent;
use Deployee\Events\PluginsInitializedEvent;
use Deployee\Events\TaskDispatcherCollectionInitializedEvent;
use Deployee\Plugins\Deploy\Events\TaskHelperCreatedEvent;
use Deployee\Plugins\DeployDb\Events\ConfigureDbConnectionDataEvent;
use Deployee\Plugins\DeployOxid\DeployOxidPlugin;
use Deployee\Plugins\DeployOxid\Dispatcher\OxidTaskDispatcher;
use Deployee\Plugins\DeployOxid\Shop\ShopConfig;
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
            TaskDispatcherCollectionInitializedEvent::EVENT_NAME => 'onTaskDispatcherCollectionInitialized',
            ConfigureDbConnectionDataEvent::EVENT_NAME => 'onConfigureDbConnectionData'
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
    }

    /**
     * @param ConfigureDbConnectionDataEvent $event
     */
    public function onConfigureDbConnectionData(ConfigureDbConnectionDataEvent $event)
    {
        $config = $event->getContainer()->plugins()->offsetGet(DeployOxidPlugin::PLUGIN_ID)->getConfig();
        if(isset($config['configure_db_plugin'])
            && $config['configure_db_plugin'] === true){
            $this->configureDbPlugin($event);
        }
    }

    /**
     * @param ConfigureDbConnectionDataEvent $event
     */
    private function configureDbPlugin(ConfigureDbConnectionDataEvent $event)
    {
        $container = $event->getContainer();
        $config = $container->plugins()->offsetGet(DeployOxidPlugin::PLUGIN_ID)->getConfig();
        if(!isset($config['shop_path'])){
            throw new \RuntimeException("You have to configure \"shop_path\" when using \"configure_db_plugin\"");
        }

        $shopPath = "";
        $find = [$config['shop_path'], getcwd() . DIRECTORY_SEPARATOR . $config['shop_path']];
        foreach($find as $path){
            if(realpath($path)
                && is_file(realpath($path) . DIRECTORY_SEPARATOR . 'config.inc.php')){
                $shopPath = realpath($path);
            }
        }

        if($shopPath === ""){
            throw new \RuntimeException("Unable to locate config.inc.php");
        }

        $dbPluginConfig = $event->getConfig();
        $shopConfig = new ShopConfig($shopPath . DIRECTORY_SEPARATOR . "config.inc.php");
        $shopHost = explode(':', $shopConfig->get('dbHost'));
        $dbPluginConfig['host'] = $shopHost[0];
        $dbPluginConfig['port'] = isset($shopHost[1]) ? $shopHost[1] : 3306;
        $dbPluginConfig['user'] = $shopConfig->get('dbUser');
        $dbPluginConfig['password'] = $shopConfig->get('dbPwd');
        $dbPluginConfig['name'] = $shopConfig->get('dbName');
        $event->setConfig($dbPluginConfig);
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