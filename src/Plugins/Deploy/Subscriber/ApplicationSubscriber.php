<?php


namespace Deployee\Plugins\Deploy\Subscriber;


use Deployee\Events\ApplicationInitializedEvent;
use Deployee\Plugins\Deploy\Commands\GenerateDeployCommand;
use Deployee\Plugins\Deploy\Commands\RunDeployCommand;
use Deployee\Plugins\Deploy\DeployPlugin;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class ApplicationSubscriber implements EventSubscriberInterface
{
    /**
     * @var DeployPlugin
     */
    private $plugin;

    /**
     * ApplicationSubscriber constructor.
     * @param DeployPlugin $plugin
     */
    public function __construct(DeployPlugin $plugin)
    {
        $this->plugin = $plugin;
    }

    /**
     * @return array
     */
    public static function getSubscribedEvents()
    {
        return [ApplicationInitializedEvent::EVENT_NAME => 'onApplicationInitialized'];
    }

    /**
     * @param ApplicationInitializedEvent $event
     */
    public function onApplicationInitialized(ApplicationInitializedEvent $event)
    {
        $generateCommand = new GenerateDeployCommand();
        $runCommand = new RunDeployCommand();

        $event->getApplication()->add($generateCommand);
        $event->getApplication()->add($runCommand);
    }
}