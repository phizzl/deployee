<?php

namespace Deployee\Kernel\Modules;


use Deployee\Kernel\Locator;

abstract class AbstractFacade implements FacadeInterface
{
    /**
     * @var FactoryInterface
     */
    protected $factory;

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

    /**
     * @param FactoryInterface $factory
     */
    public function setFactory(FactoryInterface $factory)
    {
        $this->factory = $factory;
    }

}