<?php

namespace Deployee\Plugins\DeployShell;


use Deployee\Container;
use Deployee\Plugins\AbstractPlugin;
use Deployee\Plugins\DeployShell\Services\ExecutableFinderService;
use Deployee\Plugins\DeployShell\Subscriber\DeployShellSubscriber;

class DeployShellPlugin extends AbstractPlugin
{
    const PLUGIN_ID = "deploy.shell";

    const OS_TYPE_WIN = "WIN";

    const OS_TYPE_LINUX = "LNX";

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
        $this->config['os_type'] = isset($this->config['os_type'])
            ? $this->config['os_type']
            : $this->getOsTypeByEnv();

        $this->config['aliase'] = isset($this->config['aliase']) && is_array($this->config['aliase'])
            ? $this->config['aliase']
            : [];

        $container->events()->addSubscriber(new DeployShellSubscriber());
        $container[ExecutableFinderService::CONTAINER_ID] = function(Container $di){
            return new ExecutableFinderService(
                $di,
                $di->plugins()->offsetGet(DeployShellPlugin::PLUGIN_ID)->getConfig()['aliase']
            );
        };

        $container[ShellCommandFactory::CONTAINER_ID] = function(Container $di){
            return new ShellCommandFactory($di);
        };
    }

    /**
     * @return string
     */
    public function getOsType()
    {
        return $this->config['os_type'];
    }

    /**
     * @return string
     */
    private function getOsTypeByEnv()
    {
        return strtoupper(substr(PHP_OS, 0, 3)) === 'WIN'
            ? self::OS_TYPE_WIN
            : self::OS_TYPE_LINUX;
    }
}