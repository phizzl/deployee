<?php


namespace Deployee\Application;


use Deployee\Container;

abstract class Command extends \Symfony\Component\Console\Command\Command
{
    /**
     * @var Container
     */
    protected $container;

    /**
     * @param Container $container
     */
    public function setContainer(Container $container)
    {
        $this->container = $container;
    }
}