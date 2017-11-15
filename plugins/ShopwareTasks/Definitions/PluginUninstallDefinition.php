<?php

namespace Deployee\Plugins\ShopwareTasks\Definitions;


use Deployee\Deployment\Definitions\Parameter\ParameterCollection;
use Deployee\Deployment\Definitions\Tasks\AbstractTaskDefinition;

class PluginUninstallDefinition extends AbstractTaskDefinition
{
    /**
     * @var string
     */
    private $plugin;

    /**
     * @var bool
     */
    private $secure;

    /**
     * PluginReinstallDefinition constructor.
     * @param string $plugin
     * @param bool $secure
     */
    public function __construct($plugin, $secure = false)
    {
        $this->plugin = $plugin;
        $this->secure = $secure;
    }


    /**
     * @param bool $secure
     * @return $this
     */
    public function secure($secure = true)
    {
        $this->secure = $secure;
        return $this;
    }

    /**
     * @return ParameterCollection
     */
    public function define()
    {
        return new ParameterCollection(get_object_vars($this));
    }
}