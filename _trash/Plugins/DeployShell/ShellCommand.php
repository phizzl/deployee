<?php


namespace Deployee\Plugins\DeployShell;

use Deployee\Container;

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
}