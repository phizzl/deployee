<?php


namespace Deployee\Plugins\Deploy\Subscriber;


use Deployee\Events\ApplicationInitializedEvent;
use Deployee\Plugins\Deploy\Commands\GenerateDeployCommand;
use Deployee\Plugins\Deploy\Commands\InstallCommand;
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
        $event->getApplication()->add(new InstallCommand());
        $event->getApplication()->add(new GenerateDeployCommand());
        $event->getApplication()->add(new RunDeployCommand());
    }
}