<?php


namespace Deployee\Application\Business;

use Deployee\Kernel\Locator;

abstract class Command extends \Symfony\Component\Console\Command\Command
{
    /**
     * @var Locator
     */
    protected $locator;

    /**
     * @param Locator $container
     */
    public function setLocator(Locator $locator)
    {
        $this->locator = $locator;
    }
}