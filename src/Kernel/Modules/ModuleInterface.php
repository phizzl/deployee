<?php

namespace Deployee\Kernel\Modules;

use Deployee\Kernel\Locator;

interface ModuleInterface
{
    public function onLoad();

    /**
     * @param Locator $locator
     */
    public function setLocator(Locator $locator);

    /**
     * @param FactoryInterface $factory
     */
    public function setFactory(FactoryInterface $factory);

    /**
     * @param FacadeInterface $facade
     */
    public function setFacade(FacadeInterface $facade);

    /**
     * @return FactoryInterface
     */
    public function getFactory();

    /**
     * @return FacadeInterface
     */
    public function getFacade();
}