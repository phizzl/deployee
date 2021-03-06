<?php


namespace Deployee\Plugins\Describe\Events;


use Deployee\Container;
use Deployee\Plugins\Deploy\Definitions\DefinitionCollection;
use Symfony\Component\EventDispatcher\Event;

class PreDescribeDeployment extends Event
{
    const EVENT_NAME = "deployee.plugin.deploy.describe.pre";

    /**
     * @var Container
     */
    private $container;

    /**
     * @var DefinitionCollection
     */
    private $definitions;

    /**
     * PluginsInitializedEvent constructor.
     * @param Container $container
     * @param DefinitionCollection $definitions
     */
    public function __construct(Container $container, DefinitionCollection $definitions)
    {
        $this->container = $container;
        $this->definitions = $definitions;
    }

    /**
     * @return Container
     */
    public function getContainer()
    {
        return $this->container;
    }

    /**
     * @return DefinitionCollection
     */
    public function getDefinitions()
    {
        return $this->definitions;
    }
}