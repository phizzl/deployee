<?php


namespace Deployee\Application;


use Deployee\Container;

class Application extends \Symfony\Component\Console\Application
{
    /**
     * @var Container
     */
    private $container;

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