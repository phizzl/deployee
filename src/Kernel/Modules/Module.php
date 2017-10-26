<?php

namespace Deployee\Kernel\Modules;


use Deployee\Kernel\Locator;

class Module implements ModuleInterface
{
    /**
     * @var Locator
     */
    private $locator;

    /**
     * @var FactoryInterface
     */
    private $factory;

    /**
     * @var FacadeInterface
     */
    private $facade;

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

    /**
     * @param FacadeInterface $facade
     */
    public function setFacade(FacadeInterface $facade)
    {
        $this->facade = $facade;
    }

    /**
     * @return Locator
     */
    public function getLocator()
    {
        return $this->locator;
    }

    /**
     * @return FactoryInterface
     */
    public function getFactory()
    {
        return $this->factory;
    }

    /**
     * @return FacadeInterface
     */
    public function getFacade()
    {
        return $this->facade;
    }

    /**
     * @inheritdoc
     */
    public function onLoad()
    {

    }

    /**
     * @param string $name
     * @param array $arguments
     * @return mixed
     */
    public function __call($name, $arguments)
    {
        return call_user_func_array([$this->getFacade(), $name], $arguments);
    }
}