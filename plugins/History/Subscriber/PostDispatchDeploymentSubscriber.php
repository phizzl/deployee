<?php

namespace Deployee\Plugins\History\Subscriber;


use Deployee\Kernel\Locator;
use Deployee\Plugins\History\Events\PreAddDeploymentToHistoryEvent;
use Deployee\Plugins\Pdo\Facade;
use Deployee\Plugins\Pdo\Module;
use Deployee\Plugins\RunDeploy\Events\PostDispatchDeploymentEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class PostDispatchDeploymentSubscriber implements EventSubscriberInterface
{
    /**
     * @var Locator
     */
    private $locator;

    /**
     * PostDispatchDeploymentSubscriber constructor.
     * @param Locator $locator
     */
    public function __construct(Locator $locator)
    {
        $this->locator = $locator;
    }

    /**
     * @return array
     */
    public static function getSubscribedEvents()
    {
        return [
            PostDispatchDeploymentEvent::class => 'onPostDispatchDeployment'
        ];
    }

    /**
     * @param PostDispatchDeploymentEvent $event
     */
    public function onPostDispatchDeployment(PostDispatchDeploymentEvent $event){
        /* @var Facade $pdo */
        $pdo = $this->locator->Pdo()->getFacade();
        $subEvent = new PreAddDeploymentToHistoryEvent($event->getDefinition());
        $this->locator->Events()->dispatchEvent(PreAddDeploymentToHistoryEvent::class, $subEvent);

        if($subEvent->isPreventFromAdding()){
            return;
        }

        $sql = "INSERT INTO deployee_history_deployments (`name`, `success`) VALUES(:name, :success)";
        $pdo->execute($sql, [
            ':name' => get_class($event->getDefinition()),
            ':success' => $event->isSuccess() ? 1 : 0
        ]);
    }
}