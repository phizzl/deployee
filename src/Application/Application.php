<?php


namespace Deployee\Application;


use Deployee\Container;
use Symfony\Component\Console\Input\InputOption;

class Application extends \Symfony\Component\Console\Application
{
    /**
     * @var Container
     */
    private $container;

    /**
     * Application constructor.
     * @param string $name
     * @param string $version
     */
    public function __construct($name = 'UNKNOWN', $version = 'UNKNOWN')
    {
        parent::__construct($name, $version);
        $this->getDefinition()->addOption(
            new InputOption('--env', null, InputOption::VALUE_OPTIONAL, "The environment to use")
        );
    }

    /**
     * @param Container $container
     */
    public function setContainer(Container $container)
    {
        $this->container = $container;
    }

    /**
     * @param \Symfony\Component\Console\Command\Command|Command $command
     */
    public function add(\Symfony\Component\Console\Command\Command $command)
    {
        if($command instanceof Command) {
            $command->setContainer($this->container);
        }

        parent::add($command);
    }
}