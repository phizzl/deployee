<?php

namespace Deployee\Plugins\DeployShopware\Subscriber;


use Deployee\Plugins\DeployOxid\DeployShopwarePlugin;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Deployee\Events\BootstrapFinishedEvent;
use Deployee\Plugins\DeployShell\Services\ExecutableFinderService;

class DeployShopwareSubscriber implements EventSubscriberInterface
{
    /**
     * @return array
     */
    public static function getSubscribedEvents()
    {
        return [
            BootstrapFinishedEvent::EVENT_NAME => 'onBootstrapFinished',
        ];
    }

    /**
     * @param BootstrapFinishedEvent $event
     */
    public function onBootstrapFinished(BootstrapFinishedEvent $event)
    {
        $config = $event->getContainer()->plugins()->offsetGet(DeployShopwarePlugin::PLUGIN_ID)->getConfig();
        $container = $event->getContainer();

        $console = isset($config['console_path'])
            ? $config['console_path']
            : $this->findShopwareConsole();

        $container[ExecutableFinderService::CONTAINER_ID]->addAlias("shopware", $console);
    }

    /**
     * @return string
     */
    private function findShopwareConsole()
    {
        $paths = [getcwd(), getcwd() . DIRECTORY_SEPARATOR . 'www'];
        foreach($paths as $path){
            $expectedPath = $path . DIRECTORY_SEPARATOR . 'bin' . DIRECTORY_SEPARATOR . 'console';
            if(is_file($expectedPath)){
                return $expectedPath;
            }
        }

        return './bin/console';
    }
}