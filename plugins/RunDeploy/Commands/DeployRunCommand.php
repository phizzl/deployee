<?php

namespace Deployee\Plugins\RunDeploy\Commands;


use Deployee\Application\Business\Command;
use Deployee\Deployment\Definitions\Deployments\DeploymentDefinitionInterface;
use Deployee\Deployment\Definitions\Tasks\TaskDefinitionInterface;
use Deployee\Plugins\RunDeploy\Dispatcher\DispatcherFinder;
use Deployee\Plugins\RunDeploy\Dispatcher\DispatchResult;
use Deployee\Plugins\RunDeploy\Dispatcher\DispatchResultInterface;
use Deployee\Plugins\RunDeploy\Events\DeployFailedEvent;
use Deployee\Plugins\RunDeploy\Events\FindExecutableDefinitionsEvent;
use Deployee\Plugins\RunDeploy\Events\PostDispatchDeploymentEvent;
use Deployee\Plugins\RunDeploy\Events\PostDispatchTaskEvent;
use Deployee\Plugins\RunDeploy\Events\PostRunDeploy;
use Deployee\Plugins\RunDeploy\Events\PreDispatchDeploymentEvent;
use Deployee\Plugins\RunDeploy\Events\PreDispatchTaskEvent;
use Deployee\Plugins\RunDeploy\Events\PreRunDeployEvent;
use Deployee\Plugins\RunDeploy\Module;
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
        $this->locator->Events()->getFacade()->dispatchEvent(PreRunDeployEvent::class, new PreRunDeployEvent($input));

        $definitions = $this->getExecutableDefinitions($input, $output);
        $output->writeln(sprintf("Executing %s definitions", count($definitions)));
        $success = true;
        foreach($definitions as $className){
            $output->writeln(sprintf("Execute definition %s", $className), OutputInterface::VERBOSITY_VERBOSE);
            $deployment = $this->locator->Deployment()->getFactory()->createDeploymentDefinition($className);

            $this->locator->Events()->getFacade()->dispatchEvent(PreDispatchDeploymentEvent::class, new PreDispatchDeploymentEvent($deployment));
            if($this->runDeploymentDefinition($deployment, $output) === true) {
                $output->writeln(sprintf("Finished executing definition %s", $className), OutputInterface::VERBOSITY_DEBUG);
                $this->locator->Events()->getFacade()->dispatchEvent(PostDispatchDeploymentEvent::class, new PostDispatchDeploymentEvent($deployment, true));
            }
            else{
                $output->writeln(sprintf("Error while executing definition %s", $className));
                $this->locator->Events()->getFacade()->dispatchEvent(PostDispatchDeploymentEvent::class, new PostDispatchDeploymentEvent($deployment, false));
                $success = false;
                break;
            }
        }

        $this->locator->Events()->getFacade()->dispatchEvent(PostRunDeploy::class, new PostRunDeploy($success));
    }

    /**
     * @param DeploymentDefinitionInterface $deployment
     * @param OutputInterface $output
     */
    private function runDeploymentDefinition(DeploymentDefinitionInterface $deployment, OutputInterface $output)
    {
        $return = true;
        $deployment->define();

        /* @var TaskDefinitionInterface $taskDefinition */
        foreach($deployment->getTaskDefinitions()->toArray() as $taskDefinition){
            $output->writeln("Executing " . get_class($deployment) . ' -> ' . get_class($taskDefinition), OutputInterface::VERBOSITY_DEBUG);
            $result = $this->runTaskDefinition($taskDefinition, $output);

            if($result->getExitCode() > 0){
                $return = false;
                break;
            }
        }

        return $return;
    }

    /**
     * @param TaskDefinitionInterface $taskDefinition
     * @param OutputInterface $output
     * @return DispatchResultInterface
     */
    private function runTaskDefinition(TaskDefinitionInterface $taskDefinition, OutputInterface $output){
        $event = new PreDispatchTaskEvent($taskDefinition);
        $this->locator->Events()->getFacade()->dispatchEvent(PreDispatchTaskEvent::class, $event);

        if($event->isPreventDispatch() === true){
            return new DispatchResult(0, 'Skipped execution of task definition', '');
        }

        /* @var DispatcherFinder $finder */
        $finder = $this->locator->Dependency()->getFacade()->getDependency(Module::DISPATCHER_FINDER_DEPENDENCY);
        $dispatcher = $finder->findTaskDispatcherByDefinition($taskDefinition);
        $result = $dispatcher->dispatch($taskDefinition);

        if($result->getExitCode() > 0){
            $this->exitOnFail($result, $output);
        }

        if($result->getOutput()) {
            $output->writeln($result->getOutput(), OutputInterface::VERBOSITY_VERBOSE);
        }

        $this->locator->Events()->getFacade()->dispatchEvent(PostDispatchTaskEvent::class, new PostDispatchTaskEvent($taskDefinition, $result));

        return $result;
    }

    /**
     * @param DispatchResultInterface $result
     * @param OutputInterface $output
     */
    private function exitOnFail(DispatchResultInterface $result, OutputInterface $output)
    {
        $output->write(
            sprintf(
                "Error while executing task (%s)" . PHP_EOL . "Output: %s" . PHP_EOL . "Error output: %s",
                $result->getExitCode(),
                $result->getOutput(),
                $result->getErrorOutput()
            )
        );

        $this->locator->Events()->getFacade()->dispatchEvent(DeployFailedEvent::class, new DeployFailedEvent($result));

        exit($result->getExitCode());
    }

    /**
     * @return array
     */
    private function getExecutableDefinitions(InputInterface $input, OutputInterface $output)
    {
        $deploymentDefinitions = $this->locator->Deployment()->getFacade()->findDeploymentDefinitions();

        $event = new FindExecutableDefinitionsEvent($deploymentDefinitions, $input, $output);

        $this->locator->Events()->getFacade()->dispatchEvent(FindExecutableDefinitionsEvent::class, $event);
        return $event->getDefinitions();
    }
}