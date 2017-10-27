<?php


namespace Deployee\Plugins\Deploy\Events;

use Deployee\Container;
use Deployee\Plugins\Deploy\Tasks\TaskHelper;
use Symfony\Component\EventDispatcher\Event;

class TaskHelperCreatedEvent extends Event
{
    const EVENT_NAME = "deployee.plugin.deploy.taskhelper.created";

    /**
     * @var Container
     */
    private $container;

    /**
     * @var TaskHelper
     */
    private $taskHelper;

    /**
     * PluginsInitializedEvent constructor.
     * @param Container $container
     * @param TaskHelper $taskHelper
     */
    public function __construct(Container $container, TaskHelper $taskHelper)
    {
        $this->container = $container;
        $this->taskHelper = $taskHelper;
    }

    /**
     * @return Container
     */
    public function getContainer()
    {
        return $this->container;
    }

    /**
     * @return TaskHelper
     */
    public function getTaskHelper()
    {
        return $this->taskHelper;
    }
}