<?php

namespace Phizzl\Deployee\Plugins\DeployHistory\Subscriber;


use Phizzl\Deployee\Events\BootstrapFinishedEvent;
use Phizzl\Deployee\Plugins\Deploy\Events\PostRunDeployEvent;
use Phizzl\Deployee\Plugins\Deploy\Events\PreRunDeployEvent;
use Phizzl\Deployee\Plugins\DeployHistory\Services\HistoryService;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class DeployHistorySubscriber implements EventSubscriberInterface
{
    /**
     * @return array
     */
    public static function getSubscribedEvents()
    {
        return [
            PreRunDeployEvent::EVENT_NAME => "onPreDeploy",
            PostRunDeployEvent::EVENT_NAME => "onPostDeploy",
            BootstrapFinishedEvent::EVENT_NAME => "onBootstrapFinished"
        ];
    }

    /**
     * @param PreRunDeployEvent $event
     */
    public function onPreDeploy(PreRunDeployEvent $event)
    {
        /* @var HistoryService $historyService */
        $historyService = $event->getContainer()[HistoryService::CONTAINER_ID];
        $definitions = $event->getDefinitions();
        foreach($definitions as $key => $definition){
            if($historyService->isStored($definition)){
                $event->getContainer()->logger()->debug("Already deployed " . get_class($definition));
                $definitions->offsetUnset($key);
            }
        }
    }

    /**
     * @param PostRunDeployEvent $event
     */
    public function onPostDeploy(PostRunDeployEvent $event)
    {
        /* @var HistoryService $historyService */
        $historyService = $event->getContainer()[HistoryService::CONTAINER_ID];
        $definitions = $event->getDefinitions();
        foreach($definitions as $key => $definition){
            $event->getContainer()->logger()->debug("Add to history " . get_class($definition));
            $historyService->store($definition);
        }
    }

    public function onBootstrapFinished(BootstrapFinishedEvent $event)
    {


    }
}