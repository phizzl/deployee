<?php

namespace Deployee\Plugins\RunDeploy\Dispatcher;


use Deployee\Dispatcher\TaskDispatcherInterface;

class DispatcherCollection
{
    /**
     * @var array
     */
    private $dispatcher;

    /**
     * DispatcherCollection constructor.
     */
    public function __construct()
    {
        $this->dispatcher = [];
    }

    /**
     * @param TaskDispatcherInterface $dispatcher
     */
    public function addDispatcher(TaskDispatcherInterface $dispatcher)
    {
        $this->dispatcher[] = $dispatcher;
    }

    /**
     * @return array
     */
    public function toArray()
    {
        return $this->dispatcher;
    }
}