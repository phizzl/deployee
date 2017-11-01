<?php

namespace Deployee\Plugins\RunDeploy\Commands;


use Deployee\Application\Business\Command;
use Deployee\Deployment\Definitions\Deployments\DeploymentDefinitionInterface;
use Deployee\Deployment\Definitions\Tasks\TaskDefinitionInterface;
use Deployee\Plugins\RunDeploy\Events\FindExecutableDefinitionsEvent;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class DeployRunCommand extends Command
{
    /**
     * @inheritdoc
     */
    public function configure()
    {
        parent::configure();
        $this->setName('deployee:deploy:run');
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $definitions = $this->getExecutableDefinitions();
        $output->writeln(sprintf("Executing %s definitions", count($definitions)));
        foreach($definitions as $className){
            $output->writeln(sprintf("Execute definition %s", $className), OutputInterface::VERBOSITY_VERBOSE);
            $deployment = $this->locator->Deployment()->getFactory()->createDeploymentDefinition($className);
            $this->runDepoymentDefinition($deployment, $output);
            $output->writeln(sprintf("Finished executing definition %s", $className), OutputInterface::VERBOSITY_DEBUG);
        }
    }

    /**
     * @param DeploymentDefinitionInterface $deployment
     * @param OutputInterface $output
     */
    private function runDepoymentDefinition(DeploymentDefinitionInterface $deployment, OutputInterface $output)
    {
        $deployment->define();

        /* @var TaskDefinitionInterface $task */
        foreach($deployment->getTaskDefinitions()->toArray() as $task){
            $output->writeln("Executing " . get_class($task));
        }
    }

    /**
     * @return array
     */
    private function getExecutableDefinitions()
    {
        $deploymentDefinitions = $this->locator->Deployment()->findDeploymentDefinitions();

        $event = new FindExecutableDefinitionsEvent();
        $event->setDefinitions($deploymentDefinitions);

        $this->locator->Events()->dispatchEvent(FindExecutableDefinitionsEvent::class, $event);
        return $event->getDefinitions();
    }
}