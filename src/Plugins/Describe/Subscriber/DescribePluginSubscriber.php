<?php

namespace Phizzl\Deployee\Plugins\Describe\Subscriber;


use Phizzl\Deployee\Events\ApplicationInitializedEvent;
use Phizzl\Deployee\Plugins\Describe\Commands\DescribeCommand;
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