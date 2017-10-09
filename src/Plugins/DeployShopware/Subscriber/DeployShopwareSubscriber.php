<?php

namespace Deployee\Plugins\DeployShopware\Subscriber;


use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class DeployShopwareSubscriber implements EventSubscriberInterface
{
    /**
     * @return array
     */
    public static function getSubscribedEvents()
    {
        return [];
    }
}