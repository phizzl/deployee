<?php

namespace Deployee\Kernel;

interface LocatorAwareInterface
{
    /**
     * @param Locator $locator
     * @return mixed
     */
    public function setLocator(Locator $locator);
}