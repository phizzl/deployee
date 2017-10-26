<?php

namespace Deployee\Kernel;

class Locator
{
    /**
     * @var DependencyProviderInterface
     */
    private $dependencyProvider;

    /**
     * Locator constructor.
     * @param DependencyProviderInterface $dependencyProvider
     */
    public function __construct(DependencyProviderInterface $dependencyProvider)
    {
        $this->dependencyProvider = $dependencyProvider;
    }

    /**
     * @return DependencyProviderInterface
     */
    public function getDependencyProvider()
    {
        return $this->dependencyProvider;
    }
}