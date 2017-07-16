<?php


namespace Deployee\Plugins\Deploy\Events;

use Deployee\Container;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\EventDispatcher\Event;

class InstallEvent extends Event
{
    const EVENT_NAME = "deployee.plugin.deploy.install";

    /**
     * @var Container
     */
    private $container;

    /**
     * @var InputInterface
     */
    private $input;

    /**
     * @var OutputInterface
     */
    private $output;

    /**
     * InstallEvent constructor.
     * @param Container $container
     * @param InputInterface $input
     * @param OutputInterface $output
     */
    public function __construct(Container $container, InputInterface $input, OutputInterface $output)
    {
        $this->container = $container;
        $this->input = $input;
        $this->output = $output;
    }

    /**
     * @return Container
     */
    public function getContainer()
    {
        return $this->container;
    }

    /**
     * @return InputInterface
     */
    public function getInput()
    {
        return $this->input;
    }

    /**
     * @return OutputInterface
     */
    public function getOutput()
    {
        return $this->output;
    }
}