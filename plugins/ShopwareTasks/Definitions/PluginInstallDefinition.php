<?php

namespace Deployee\Plugins\ShopwareTasks\Definitions;


use Deployee\Deployment\Definitions\Parameter\ParameterCollection;
use Deployee\Deployment\Definitions\Tasks\AbstractTaskDefinition;

class PluginInstallDefinition extends AbstractTaskDefinition
{
    /**
     * @var string
     */
    private $plugin;

    /**
     * @var bool
     */
    private $activate;

    /**
     * PluginInstallDefinition constructor.
     * @param string $plugin
     * @param bool $activate
     */
    public function __construct($plugin, $activate = false)
    {
        $this->plugin = $plugin;
        $this->activate = $activate;
    }

    /**
     * @param bool $activate
     * @return $this
     */
    public function activate($activate = true)
    {
        $this->activate = $activate;
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