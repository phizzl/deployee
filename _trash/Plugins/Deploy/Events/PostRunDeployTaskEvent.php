<?php


namespace Deployee\Plugins\Deploy\Events;

use Deployee\Container;
use Deployee\Dispatcher\TaskDispatchResultInterface;
use Deployee\Tasks\TaskInterface;
use Symfony\Component\EventDispatcher\Event;

class PostRunDeployTaskEvent extends Event
{
    const EVENT_NAME = "deployee.plugin.deploy.task.post";

    /**
     * @var Container
     */
    private $container;

    /**
     * @var TaskInterface
     */
    private $task;

    /**
     * @var TaskDispatchResultInterface
     */
    private $result;

    /**
     * PluginsInitializedEvent constructor.
     * @param Container $container
     * @param TaskInterface $task
     * @param TaskDispatchresultInterface $result
     */
    public function __construct(Container $container, TaskInterface $task, TaskDispatchResultInterface $result)
    {
        $this->container = $container;
        $this->task = $task;
        $this->result = $result;
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

    /**
     * @return TaskDispatchResultInterface
     */
    public function getResult()
    {
        return $this->result;
    }
}