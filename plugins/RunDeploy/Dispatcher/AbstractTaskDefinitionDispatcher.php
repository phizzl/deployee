<?php

namespace Deployee\Plugins\RunDeploy\Dispatcher;


use Deployee\Deployment\Definitions\Tasks\TaskDefinitionInterface;
use Deployee\Kernel\Locator;
use Deployee\Plugins\RunDeploy\Module;

abstract class AbstractTaskDefinitionDispatcher implements TaskDefinitionDispatcherInterface
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

    /**
     * @param TaskDefinitionInterface $taskDefinition
     * @return DispatchResultInterface
     */
    protected function delegate(TaskDefinitionInterface $taskDefinition)
    {
        /* @var DispatcherFinder $finder */
        $finder = $this->locator->Dependency()->getDependency(Module::DISPATCHER_FINDER_DEPENDENCY);
        $dispatcher = $finder->findTaskDispatcherByDefinition($taskDefinition);
        return $dispatcher->dispatch($taskDefinition);
    }
}