<?php

namespace Deployee\Plugins\Describe\Subscriber;


use Deployee\Events\ApplicationInitializedEvent;
use Deployee\Plugins\Describe\Commands\DescribeCommand;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class DescribePluginSubscriber implements EventSubscriberInterface
{
    /**
     * @return array
     */
    public static function getSubscribedEvents()
    {
        return [
            ApplicationInitializedEvent::EVENT_NAME => "onApplicationInitialized"
        ];
    }

    /**
     * @param ApplicationInitializedEvent $event
     */
    public function onApplicationInitialized(ApplicationInitializedEvent $event)
    {
        $command = new DescribeCommand();
        $event->getApplication()->add($command);
    }
}