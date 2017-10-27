<?php

namespace Deployee\Plugins\DeployShopware\Subscriber;


use Deployee\Plugins\DeployOxid\DeployShopwarePlugin;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Deployee\Events\BootstrapFinishedEvent;
use Deployee\Plugins\DeployShell\Services\ExecutableFinderService;
use Deployee\Events\TaskDispatcherCollectionInitializedEvent;
use Deployee\Plugins\Deploy\Events\TaskHelperCreatedEvent;
use Deployee\Plugins\DeployDb\Events\ConfigureDbConnectionDataEvent;
use Deployee\Plugins\DeployShopwareShop\ShopConfig;
use Deployee\Plugins\DeployShopware\Dispatcher\CreateAdminTaskDispatcher;

class DeployShopwareSubscriber implements EventSubscriberInterface
{
    /**
     * @var array
     */
    private $pluginConfig;

    /**
     * DeployOxidSubscriber constructor.
     * @param array $pluginConfig
     */
    public function __construct(array $pluginConfig)
    {
        $this->pluginConfig = $pluginConfig;
    }

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
     * @param BootstrapFinishedEvent $event
     */
    public function onBootstrapFinished(BootstrapFinishedEvent $event)
    {
        $config = $event->getContainer()->plugins()->offsetGet(DeployShopwarePlugin::PLUGIN_ID)->getConfig();
        $container = $event->getContainer();

        $console = isset($config['console_path'])
            ? $config['console_path']
            : $this->findShopwareConsole();

        $container[ExecutableFinderService::CONTAINER_ID]->addAlias("shopware", $console);
    }

    /**
     * @return string
     */
    private function findShopwareConsole()
    {
        $paths = [
            $this->pluginConfig['shop_path'],
            getcwd() . DIRECTORY_SEPARATOR . $this->pluginConfig['shop_path'],
            getcwd()
        ];

        foreach($paths as $path){
            $expectedPath = $path . DIRECTORY_SEPARATOR . 'bin' . DIRECTORY_SEPARATOR . 'console';
            if(is_file($expectedPath)){
                return $expectedPath;
            }
        }

        return './bin/console';
    }

    /**
     * @param TaskHelperCreatedEvent $event
     */
    public function onTaskHelperCreated(TaskHelperCreatedEvent $event)
    {
        $taskHelper = $event->getTaskHelper();
        $taskHelper->registerTask('Deployee\Plugins\DeployShopware\Tasks\CreateAdminTask', 'shopwareAdmin');
    }

    /**
     * @param TaskDispatcherCollectionInitializedEvent $event
     */
    public function onTaskDispatcherCollectionInitialized(TaskDispatcherCollectionInitializedEvent $event)
    {
        $collection = $event->getTaskDispatcherCollection();
        $collection->registerDispatcher(new CreateAdminTaskDispatcher($event->getContainer()));
    }

    /**
     * @param ConfigureDbConnectionDataEvent $event
     */
    public function onConfigureDbConnectionData(ConfigureDbConnectionDataEvent $event)
    {
        if(isset($this->pluginConfig['configure_db_plugin'])
            && $this->pluginConfig['configure_db_plugin'] === true){
            $this->configureDbPlugin($event);
        }
    }

    /**
     * @param ConfigureDbConnectionDataEvent $event
     */
    private function configureDbPlugin(ConfigureDbConnectionDataEvent $event)
    {
        if(!isset($this->pluginConfig['shop_path'])){
            throw new \RuntimeException("You have to configure \"shop_path\" when using \"configure_db_plugin\"");
        }

        $shopPath = "";
        $find = [$this->pluginConfig['shop_path'], getcwd() . DIRECTORY_SEPARATOR . $this->pluginConfig['shop_path']];
        foreach($find as $path){
            if(realpath($path)
                && is_file(realpath($path) . DIRECTORY_SEPARATOR . 'config.php')){
                $shopPath = realpath($path);
            }
        }

        if($shopPath === ""){
            throw new \RuntimeException("Unable to locate config.php");
        }

        $dbPluginConfig = $event->getConfig();
        $shopConfig = new ShopConfig($shopPath . DIRECTORY_SEPARATOR . "config.php");
        $dbConfig = $shopConfig->get('db');
        $dbPluginConfig['host'] = $dbConfig['host'];
        $dbPluginConfig['port'] = $dbConfig['port'];
        $dbPluginConfig['user'] = $dbConfig['username'];
        $dbPluginConfig['password'] = $dbConfig['password'];
        $dbPluginConfig['name'] = $dbConfig['dbname'];
        $event->setConfig($dbPluginConfig);
    }
}