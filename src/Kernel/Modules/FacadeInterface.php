<?php

namespace Deployee\Kernel\Modules;

use Deployee\Kernel\LocatorAwareInterface;

interface FacadeInterface extends LocatorAwareInterface
{
    /**
     * @param FactoryInterface $factory
     */
    public function setFactory(FactoryInterface $factory);
}