<?php

namespace Deployee\Events;


use Deployee\Kernel\Locator;
use Deployee\Kernel\LocatorAwareInterface;
use Symfony\Component\EventDispatcher\Event;

class AbstractEvent extends Event implements LocatorAwareInterface
{
    /**
     * @var Locator
     */
    private $locator;

    /**
     * @return Locator
     */
    public function getLocator()
    {
        return $this->locator;
    }

    /**
     * @param Locator $locator
     */
    public function setLocator(Locator $locator)
    {
        $this->locator = $locator;
    }
}