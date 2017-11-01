<?php

namespace Deployee\Deployment\Definitions\Tasks;


use Deployee\Kernel\Locator;

abstract class AbstractTaskDefinition implements TaskDefinitionInterface
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