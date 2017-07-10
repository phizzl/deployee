<?php


namespace Phizzl\Deployee\Plugins\DeployShell\Services;


use Phizzl\Deployee\Collection;
use Phizzl\Deployee\Container;
use Phizzl\Deployee\Plugins\DeployShell\DeployShellPlugin;
use Phizzl\Deployee\Plugins\DeployShell\ShellCommand;
use Phizzl\Deployee\Plugins\DeployShell\ShellCommandFactory;

class ExecutableFinderService
{
    const CONTAINER_ID = "plugin.deployshell.services.executablefinder";

    /**
     * @var Collection
     */
    private $aliase;

    /**
     * @var Container
     */
    private $container;

    /**
     * ExecutableFinderService constructor.
     * @param array $alias
     */
    public function __construct(Container $container, array $aliase = [])
    {
        $this->container = $container;
        $this->aliase = new Collection($aliase);
    }

    /**
     * @param string $name
     * @return string
     */
    public function find($name)
    {
        $return = $name;
        if(isset($this->aliase[$name])){
            $return = $this->aliase[$name];
        }
        elseif($path = $this->which($name)){
            $return = $path;
        }

        return $return;
    }

    /**
     * Usage:
     * ExecutableFinderService::addAlias('mysqldump', '/usr/local/mysql5/bin/mysqldump')
     *
     * @param string $alias
     * @param string $resolved
     */
    public function addAlias($alias, $resolved)
    {
        $this->aliase->offsetSet($alias, $resolved);
    }

    /**
     * @param string $name
     * @return string
     */
    private function which($name)
    {
        $osType = $this->container
                ->plugins()
                ->offsetGet(DeployShellPlugin::PLUGIN_ID)
                ->getOsType();

        $which = $osType === DeployShellPlugin::OS_TYPE_WIN ? "where" : "which";

        /* @var ShellCommand $command */
        $command = $this->container[ShellCommandFactory::CONTAINER_ID]->create("$which $name");
        $return = $command->run();

        return $return['code'] > 0 ? '' : current($return['output']);
    }
}