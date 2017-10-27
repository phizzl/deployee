<?php

namespace Deployee\Plugins\RunDeploy\Commands;


use Deployee\Application\Business\Command;
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

            $output->writeln(sprintf("Finished executing definition %s", $className), OutputInterface::VERBOSITY_DEBUG);
        }
    }

    private function executeDefinition($className)
    {

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