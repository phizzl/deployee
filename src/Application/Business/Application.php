<?php


namespace Deployee\Application\Business;

use Deployee\Kernel\Locator;
use Symfony\Component\Console\Input\InputOption;

class Application extends \Symfony\Component\Console\Application
{
    /**
     * @var Locator
     */
    private $locator;

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
     * @param Locator $container
     */
    public function setLocator(Locator $locator)
    {
        $this->locator = $locator;
    }

    /**
     * @param \Symfony\Component\Console\Command\Command|Command $command
     */
    public function add(\Symfony\Component\Console\Command\Command $command)
    {
        if($command instanceof Command) {
            $command->setLocator($this->locator);
        }

        parent::add($command);
    }
}