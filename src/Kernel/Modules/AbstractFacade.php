<?php

namespace Deployee\Kernel\Modules;


use Deployee\Kernel\Locator;

abstract class AbstractFacade implements FacadeInterface
{
    /**
     * @var Locator
     */
    protected $locator;

    /**
     * @param Locator $locator
     */
    public function setLocator(Locator $locator)
    {
        $this->locator = $locator;
    }
}