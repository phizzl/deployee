<?php

namespace Phizzl\Deployee\Plugins\DeployHistory;


use Phizzl\Deployee\Container;
use Phizzl\Deployee\Plugins\AbstractPlugin;
use Phizzl\Deployee\Plugins\DeployDb\DeployDbPlugin;
use Phizzl\Deployee\Plugins\DeployHistory\Services\HistoryService;
use Phizzl\Deployee\Plugins\DeployHistory\Storages\MySqlDefinitionStorage;
use Phizzl\Deployee\Plugins\DeployHistory\Subscriber\DeployHistorySubscriber;

class DeployHistoryPlugin extends AbstractPlugin
{
    const PLUGIN_ID = "deploy.history";

    /**
     * @return string
     */
    public function getPluginId()
    {
        return self::PLUGIN_ID;
    }

    /**
     * @param Container $container
     */
    public function initialize(Container $container)
    {
        $container->events()->addSubscriber(new DeployHistorySubscriber());

        $container[HistoryService::CONTAINER_ID] = function(Container $container){
            /* @var DeployDbPlugin $dbPlugin */
            $dbPlugin = $container->plugins()->offsetGet(DeployDbPlugin::PLUGIN_ID);
            $dbPluginConfig = $dbPlugin->getConfig();
            $storage = new MySqlDefinitionStorage(
                $dbPluginConfig['host'],
                $dbPluginConfig['port'],
                $dbPluginConfig['user'],
                $dbPluginConfig['password'],
                $dbPluginConfig['name']
            );
            return new HistoryService($storage);
        };
    }

}