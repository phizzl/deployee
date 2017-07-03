<?php


namespace Phizzl\Deployee\Events;


use Phizzl\Deployee\Container;
use Phizzl\Deployee\Dispatcher\TaskDispatcherCollection;
use Symfony\Component\EventDispatcher\Event;

class TaskDispatcherCollectionInitializedEvent extends Event
{
    const EVENT_NAME = "deployee.tasks.dispatchercollection.initialized";

    /**
     * @var Container
     */
    private $container;

    /**
     * @var TaskDispatcherCollection
     */
    private $collection;

    /**
     * PluginsInitializedEvent constructor.
     * @param Container $container
     * @param TaskDispatcherCollection $plugins
     */
    public function __construct(Container $container, TaskDispatcherCollection $collection)
    {
        $this->container = $container;
        $this->collection = $collection;
    }

    /**
     * @return Container
     */
    public function getContainer()
    {
        return $this->container;
    }

    /**
     * @return TaskDispatcherCollection
     */
    public function getTaskDispatcherCollection()
    {
        return $this->collection;
    }
}