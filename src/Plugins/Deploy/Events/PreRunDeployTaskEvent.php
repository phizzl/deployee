<?php


namespace Deployee\Plugins\Deploy\Events;

use Deployee\Container;
use Deployee\Tasks\TaskInterface;
use Symfony\Component\EventDispatcher\Event;

class PreRunDeployTaskEvent extends Event
{
    const EVENT_NAME = "deployee.plugin.deploy.task.pre";

    /**
     * @var Container
     */
    private $container;

    /**
     * @var TaskInterface
     */
    private $task;

    /**
     * PluginsInitializedEvent constructor.
     * @param Container $container
     * @param TaskInterface $task
     */
    public function __construct(Container $container, TaskInterface $task)
    {
        $this->container = $container;
        $this->task = $task;
    }

    /**
     * @return Container
     */
    public function getContainer()
    {
        return $this->container;
    }

    /**
     * @return TaskInterface
     */
    public function getTask()
    {
        return $this->task;
    }
}