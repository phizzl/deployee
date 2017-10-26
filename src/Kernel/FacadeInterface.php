<?php

namespace Deployee\Kernel;


interface FacadeInterface
{
    /**
     * @param FactoryInterface $factory
     */
    public function setFactory(FactoryInterface $factory);
}