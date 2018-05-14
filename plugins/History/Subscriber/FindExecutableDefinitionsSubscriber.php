<?php

namespace Deployee\Plugins\History\Subscriber;

use Deployee\Kernel\Locator;
use Deployee\Plugins\Pdo\Facade;
use Deployee\Plugins\RunDeploy\Events\FindExecutableDefinitionsEvent;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class FindExecutableDefinitionsSubscriber implements EventSubscriberInterface
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
            FindExecutableDefinitionsEvent::class => 'onFindExecutableDefinitions'
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
     * @param FindExecutableDefinitionsEvent $event
     */
    public function onFindExecutableDefinitions(FindExecutableDefinitionsEvent $event)
    {
        /* @var Facade $pdo */
        $pdo = $this->locator->Pdo()->getFacade();
        $executableDefinitions = [];
        foreach($event->getDefinitions() as $className){
            $sql = "SELECT COUNT(*) AS c FROM deployee_history_deployments WHERE `name`=:name AND success=1";
            if((int)$pdo->selectOne($sql, [':name' => $className]) > 0){
                $event->getOutput()->writeln(
                    sprintf('Deployment %s already executed. Skipping', $className),
                    OutputInterface::VERBOSITY_DEBUG
                );
                continue;
            }

            $executableDefinitions[] = $className;
        }

        $event->setDefinitions($executableDefinitions);
    }
}