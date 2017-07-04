<?php


namespace Phizzl\Deployee\Plugins\DeployShell;

use Phizzl\Deployee\Container;

class ShellCommand
{
    const EXIT_CODE_OK = 0;

    /**
     * @var Container
     */
    private $container;

    /**
     * @var string
     */
    private $command;

    /**
     * ShellCommand constructor.
     * @param Container $container
     * @param string $command
     */
    public function __construct(Container $container, $command)
    {
        $this->container = $container;
        $this->command = $command;
    }

    /**
     * @return array
     */
    public function run()
    {
        exec($this->command, $output, $exitCode);

        return [
            'output' => $output,
            'code' => $exitCode
        ];
    }

    /**
     * @param string $command
     * @return string
     */
    private function exec($command)
    {

        return trim(shell_exec($command));
    }

    /**
     * @return int
     */
    private function getExitCode()
    {
        $exitCodeVar = $this->getOsType() === DeployShellPlugin::OS_TYPE_WIN ? "%errorlevel%" : "\$?";
        return trim($r = $this->exec("echo $exitCodeVar")) === "" ? 255 : (int)$r;
    }

    /**
     * @return string
     */
    private function getOsType()
    {
        return $this->container->plugins()->offsetGet(DeployShellPlugin::PLUGIN_ID)->getOsType();
    }
}