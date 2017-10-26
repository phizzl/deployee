<?php

namespace Deployee\Kernel\Modules;


interface FacadeInterface
{
    /**
     * @param FactoryInterface $factory
     */
    public function setFactory(FactoryInterface $factory);
}