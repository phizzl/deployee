<?php

namespace Deployee\Bootstrap;


use Deployee\Container;
use Deployee\Events\BootstrapFinishedEvent;

class Bootstrap
{
    use RegisterEventDispatcherTrait;
    use RegisterConfigTrait;
    use RegisterPluginsTrait;
    use RegisterTaskDispatcherCollectionTrait;
    use RegisterLoggerTrait;

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
        $this->registerLogger();

        // phs: Ensure plugin container is build an all plugins are initialized
        $this->getContainer()->plugins();

        $this->getContainer()
            ->events()
            ->dispatch(
                BootstrapFinishedEvent::EVENT_NAME,
                new BootstrapFinishedEvent($this->getContainer())
            );

        return $this->getContainer();
    }
}