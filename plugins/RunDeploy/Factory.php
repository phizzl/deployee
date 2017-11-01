<?php

namespace Deployee\Plugins\RunDeploy;


use Deployee\Kernel\Modules\AbstractFactory;
use Deployee\Plugins\RunDeploy\Dispatcher\DispatcherCollection;
use Deployee\Plugins\RunDeploy\Dispatcher\DispatcherFinder;
use Deployee\Plugins\RunDeploy\Dispatcher\TaskDefinitionDispatcherInterface;
use Symfony\Component\Yaml\Exception\RuntimeException;

class Factory extends AbstractFactory
{
    /**
     * @return DispatcherCollection
     */
    public function createDispatcherCollection()
    {
        return new DispatcherCollection();
    }

    /**
     * @return DispatcherFinder
     */
    public function createDispatcherFinder()
    {
        return new DispatcherFinder($this->locator);
    }

    /**
     * @param string $className
     * @return TaskDefinitionDispatcherInterface
     */
    public function createDispatcher($className)
    {
        /* @var TaskDefinitionDispatcherInterface $dispatcher */
        if(!($dispatcher = new $className) instanceof TaskDefinitionDispatcherInterface){
            throw new RuntimeException(spintf("Invalid dispatcher class %s", $className));
        }

        $dispatcher->setLocator($this->locator);
        return $dispatcher;
    }
}