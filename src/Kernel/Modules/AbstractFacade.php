<?php

namespace Deployee\Kernel\Modules;


abstract class AbstractFacade implements FacadeInterface
{
    /**
     * @var FactoryInterface
     */
    protected $factory;

    /**
     * @param FactoryInterface $factory
     */
    public function setFactory(FactoryInterface $factory)
    {
        $this->factory = $factory;
    }

}