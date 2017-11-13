<?php

namespace Deployee\Plugins\History\Subscriber;


use Deployee\Kernel\Locator;
use Deployee\Plugins\History\Events\PreAddDeploymentToHistoryEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class PreAddDeploymentToHistorySubscriber implements EventSubscriberInterface
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
            PreAddDeploymentToHistoryEvent::class => 'onPreAddDeploymentToHistoryEvent'
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
     * @param PreAddDeploymentToHistoryEvent $event
     */
    public function onPreAddDeploymentToHistoryEvent(PreAddDeploymentToHistoryEvent $event)
    {
        $definition = $event->getDefinition();
        if($this->locator->Annotations()->getFacade()->hasTag($definition, 'runalways')){
            $event->setPreventFromAdding(true);
        }
    }
}