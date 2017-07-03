<?php


namespace Phizzl\Deployee\Plugins\Deploy\Commands;


use Phizzl\Deployee\Plugins\Deploy\DeployPlugin;

trait SetPluginTrait
{
    /**
     * @var DeployPlugin
     */
    private $plugin;

    /**
     * @param DeployPlugin $plugin
     */
    public function setPlugin(DeployPlugin $plugin)
    {
        $this->plugin = $plugin;
    }
}