<?php

namespace Deployee\Bootstrap;

use Deployee\Config\Config;
use Deployee\Container;
use Deployee\Events\EventDispatcher;
use Deployee\Events\PluginsInitializedEvent;
use Deployee\Plugins\PluginContainer;
use Deployee\Plugins\PluginInterface;

/**
 * @mixin Bootstrap
 */
trait RegisterPluginsTrait
{
    public function registerPlugins()
    {
        /**
         * @param Container $di
         * @return PluginContainer
         */
        $this->getContainer()[PluginContainer::CONTAINER_ID] = function(Container $di){
            /* @var Config $config */
            $config = $di[Config::CONTAINER_ID];
            /* @var EventDispatcher $eventDispatcher */
            $eventDispatcher = $di[EventDispatcher::CONTAINER_ID];
            $configuredPlugins = $config->get('plugins', []);
            $plugins = new PluginContainer();

            foreach($configuredPlugins as $key => $configuredPlugin){
                $pluginClass = $configuredPlugin;
                $pluginConfig = [];
                if(is_array($configuredPlugin)){
                    $pluginClass = current(array_keys($configuredPlugin));
                    $pluginConfig = current(array_values($configuredPlugin));
                }

                if(!class_exists($pluginClass)){
                    throw new \RuntimeException("Plugin colud not be loaded \"$pluginClass\"");
                }

                /* @var PluginInterface $plugin */
                if(!($plugin = new $pluginClass) instanceof PluginInterface){
                    throw new \RuntimeException("All plugins must implement the Deployee\\Plugins\\PluginInterface interface");
                }

                $plugin->setConfig($pluginConfig);
                $plugin->initialize($di);
                $plugins[$plugin->getPluginId()] = $plugin;
            }

            $eventDispatcher->dispatch(PluginsInitializedEvent::EVENT_NAME, new PluginsInitializedEvent($di, $plugins));

            return $plugins;
        };
    }
}