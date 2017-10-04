<?php

namespace Deployee\Plugins\DeployAnnotation\Subscriber;


use Deployee\Bootstrap\BootstrapArguments;
use Deployee\Plugins\Deploy\Definitions\DeploymentDefinitionInterface;
use Deployee\Plugins\Deploy\Events\PreRunDeployEvent;
use Deployee\Plugins\DeployHistory\Events\PreAddToHistoryEvent;
use phpDocumentor\Reflection\DocBlock\Tags\Generic;
use phpDocumentor\Reflection\DocBlockFactory;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class DeployAnnotationSubscriber implements EventSubscriberInterface
{
    /**
     * @return array
     */
    public static function getSubscribedEvents()
    {
        return [
            PreAddToHistoryEvent::EVENT_NAME => 'onPreAddToHistory',
            PreRunDeployEvent::EVENT_NAME => 'onPreRunDeploy'
        ];
    }

    /**
     * @param PreRunDeployEvent $event
     */
    public function onPreRunDeploy(PreRunDeployEvent $event)
    {
        $env = $event->getContainer()[BootstrapArguments::CONATINER_ID]->getOption('env');

        foreach($event->getDefinitions() as $offset => $definition){
            if(!$this->canRunOnEnv($definition, $env)){
                $event->getContainer()->logger()->debug("Skipping definition. Env does not match: " . get_class($definition));
                $event->getDefinitions()->offsetUnset($offset);
                $event->getDefinitions()->rewind();
            }
        }
    }

    /**
     * @param DeploymentDefinitionInterface $definition
     * @param string $env
     * @return bool
     */
    private function canRunOnEnv(DeploymentDefinitionInterface $definition, $env)
    {
        $factory  = DocBlockFactory::createInstance();
        $docBlock = $factory->create(new \ReflectionClass($definition));
        $tags = $docBlock->getTagsByName('env');
        $envTagMatch = false;

        /* @var Generic $tag */
        foreach($tags as $tag){
            if(trim($tag->getDescription()) == $env){
                $envTagMatch = true;
            }
        }

        return count($tags) === 0 || $envTagMatch === true;
    }

    /**
     * @param PreAddToHistoryEvent $event
     */
    public function onPreAddToHistory(PreAddToHistoryEvent $event)
    {
        foreach($event->getDefinitions() as $offset => $definition){
            if($this->removeDefinitionFromHistory($definition)){
                $event->getContainer()->logger()->debug("Prevent from adding to history. Run always tag found: " . get_class($definition));
                $event->getDefinitions()->offsetUnset($offset);
                $event->getDefinitions()->rewind();
            }
        }
    }

    /**
     * @param DeploymentDefinitionInterface $definition
     * @return bool
     */
    private function removeDefinitionFromHistory(DeploymentDefinitionInterface $definition)
    {
        $factory  = DocBlockFactory::createInstance();
        $docBlock = $factory->create(new \ReflectionClass($definition));


        return $docBlock->hasTag('runalways');
    }
}