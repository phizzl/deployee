<?php

namespace Deployee\Plugins;


use Deployee\Container;

interface PluginInterface
{
    /**
     * Return a unique identifier for the plugin. It's been used to access the plugin within the defined tasks
     * @return string
     */
    public function getPluginId();

    /**
     * Sets the plugin config
     * @param array $config
     */
    public function setConfig(array $config);

    /**
     * Gets the plugin config
     * @return array
     */
    public function getConfig();

    /**
     * This is been called after creating the plugin instance
     * @param Container $container
     */
    public function initialize(Container $container);
}