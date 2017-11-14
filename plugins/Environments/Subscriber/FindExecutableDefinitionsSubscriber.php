<?php

namespace Deployee\Plugins\Environments\Subscriber;

use Deployee\Kernel\Locator;
use Deployee\Plugins\Environments\Module;
use Deployee\Plugins\Pdo\Facade;
use Deployee\Plugins\RunDeploy\Events\FindExecutableDefinitionsEvent;
use phpDocumentor\Reflection\DocBlock\Tags\Generic;
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
        $executableDefinitions = [];
        $selectedEnv = $this->locator->Dependency()->getFacade()->getDependency(Module::CURRENT_ENVIRONMENT_DEPENDENCY)->getName();
        foreach($event->getDefinitions() as $className){
            $tags = $this->locator->Annotations()->getFacade()->getTagsByName($className, 'env');
            if(!count($tags)
                || $this->tagsContainEnv($tags, $selectedEnv)){
                $executableDefinitions[] = $className;
            }
        }

        $event->setDefinitions($executableDefinitions);
    }

    /**
     * @param array $envTags
     * @param string $searchForEnv
     * @return bool
     */
    private function tagsContainEnv(array $envTags, $searchForEnv)
    {
        /* @var Generic $envTag */
        foreach($envTags as $envTag){
            if(trim($envTag->getDescription()) === $searchForEnv){
                return true;
            }
        }

        return false;
    }
}