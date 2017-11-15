<?php

namespace Deployee\Plugins\ShopwareTasks\Definitions;


use Deployee\Deployment\Definitions\Parameter\ParameterCollection;
use Deployee\Deployment\Definitions\Tasks\AbstractTaskDefinition;

class PluginDeactivateDefinition extends AbstractTaskDefinition
{
    /**
     * @var string
     */
    private $plugin;

    /**
     * PluginInstallDefinition constructor.
     * @param string $plugin
     */
    public function __construct($plugin)
    {
        $this->plugin = $plugin;
    }

    /**
     * @return ParameterCollection
     */
    public function define()
    {
        return new ParameterCollection(get_object_vars($this));
    }
}