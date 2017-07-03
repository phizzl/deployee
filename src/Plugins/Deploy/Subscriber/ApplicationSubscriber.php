<?php


namespace Phizzl\Deployee\Plugins\Deploy\Subscriber;


use Phizzl\Deployee\Events\ApplicationInitializedEvent;
use Phizzl\Deployee\Plugins\Deploy\Commands\GenerateDeployCommand;
use Phizzl\Deployee\Plugins\Deploy\Commands\RunDeployCommand;
use Phizzl\Deployee\Plugins\Deploy\DeployPlugin;
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
        $generateCommand->setPlugin($this->plugin);
        $runCommand = new RunDeployCommand();
        $runCommand->setPlugin($this->plugin);

        $event->getApplication()->add($generateCommand);
        $event->getApplication()->add($runCommand);
    }
}