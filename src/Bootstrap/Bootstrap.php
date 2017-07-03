<?php

namespace Phizzl\Deployee\Bootstrap;


use Phizzl\Deployee\Container;
use Phizzl\Deployee\Subscriber\TaskDispatcherCollectionInitializedSubscriber;

class Bootstrap
{
    use RegisterEventDispatcherTrait;
    use RegisterConfigTrait;
    use RegisterPluginsTrait;
    use RegisterTaskDispatcherCollectionTrait;

    /**
     * @var Container
     */
    private $container;

    /**
     * Bootstrap constructor.
     * @param Container $container
     */
    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    /**
     * @return Container
     */
    public function getContainer()
    {
        return $this->container;
    }

    /**
     * Run bootstrap an register services to the DI container
     * @return Container
     */
    public function bootstrap()
    {
        $this->registerEventDispatcher();
        $this->registerConfigLoader();
        $this->registerConfig();
        $this->registerPlugins();
        $this->registerTaskDispatcherCollection();
        $this->addSubscriber();

        return $this->getContainer();
    }

    /**
     * Adds internal event subscriber
     */
    private function addSubscriber()
    {
        $this->container->events()->addSubscriber(new TaskDispatcherCollectionInitializedSubscriber());
    }
}