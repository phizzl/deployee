<?php

namespace Phizzl\Deployee\Plugins\DeployShell;


use Phizzl\Deployee\Container;

class ShellCommandFactory
{
    const CONTAINER_ID = "deployee.plugins.deployshell.factories.shellcommand";

    /**
     * @var Container
     */
    private $container;

    /**
     * ShellCommandFactory constructor.
     * @param Container $container
     */
    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    /**
     * @param string $command
     * @return ShellCommand
     */
    public function create($command)
    {
        return new ShellCommand($this->container, $command);
    }
}