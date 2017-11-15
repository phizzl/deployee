<?php

namespace Deployee\Plugins\ShopwareTasks\Definitions;


use Deployee\Deployment\Definitions\Parameter\ParameterCollection;
use Deployee\Deployment\Definitions\Tasks\AbstractTaskDefinition;

class PluginReinstallDefinition extends AbstractTaskDefinition
{
    /**
     * @var string
     */
    private $plugin;

    /**
     * @var bool
     */
    private $removedata;

    /**
     * PluginReinstallDefinition constructor.
     * @param string $plugin
     * @param bool $removedata
     */
    public function __construct($plugin, $removedata = false)
    {
        $this->plugin = $plugin;
        $this->removedata = $removedata;
    }


    /**
     * @param bool $activate
     * @return $this
     */
    public function removedata($removedata = true)
    {
        $this->removedata = $removedata;
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