<?php

namespace Deployee\Plugins\Environments\Subscriber;


use Deployee\Kernel\Locator;
use Deployee\Plugins\Environments\Environment;
use Deployee\Plugins\Environments\Module;
use Deployee\Plugins\RunDeploy\Events\PreRunDeployEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class PreRunDeploySubscriber implements EventSubscriberInterface
{
    /**
     * @var Locator
     */
    private $locator;

    /**
     * @return array
     */
    public static function getSubscribedEvents()
    {
        return [
            PreRunDeployEvent::class => 'onPreRunDeploy'
        ];
    }

    /**
     * FindExecutableDefinitionsSubscriber constructor.
     * @param Locator $locator
     */
    public function __construct(Locator $locator)
    {
        $this->locator = $locator;
    }

    /**
     * @param PreRunDeployEvent $event
     */
    public function onPreRunDeploy(PreRunDeployEvent $event)
    {
        if($name = $event->getInput()->getOption('env')) {
            $this->locator
                ->Dependency()
                ->getFacade()
                ->getDependency(Module::CURRENT_ENVIRONMENT_DEPENDENCY)
                ->setName($name);
        }
    }
}