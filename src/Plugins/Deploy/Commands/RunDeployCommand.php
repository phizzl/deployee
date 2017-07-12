<?php


namespace Deployee\Plugins\Deploy\Commands;


use Deployee\Application\Command;
use Deployee\CollectionInterface;
use Deployee\Plugins\Deploy\Definitions\AbstractDeploymentDefinition;
use Deployee\Plugins\Deploy\Definitions\DefinitionFinder;
use Deployee\Plugins\Deploy\Events\PostRunDeployEvent;
use Deployee\Plugins\Deploy\Events\PreRunDeployEvent;
use Deployee\Tasks\TaskInterface;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class RunDeployCommand extends Command
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
        $finder = new DefinitionFinder($this->container);
        $definitions = $finder->find();

        $event = new PreRunDeployEvent($this->container, $definitions);
        $this->container->events()->dispatch(PreRunDeployEvent::EVENT_NAME, $event);

        /* @var AbstractDeploymentDefinition $definition */
        foreach($definitions as $definition){
            $output->writeln("Executing definition " . get_class($definition));
            $definition->define();
            $this->runTasks($definition->getTasks(), $output);
        }

        $event = new PostRunDeployEvent($this->container, $definitions);
        $this->container->events()->dispatch(PostRunDeployEvent::EVENT_NAME, $event);
    }

    /**
     * @param CollectionInterface $tasks
     * @param OutputInterface $output
     */
    private function runTasks(CollectionInterface $tasks, OutputInterface $output){
        /* @var TaskInterface $task */
        foreach($tasks as $task) {
            $output->writeln("Executing task " . get_class($task), OutputInterface::VERBOSITY_DEBUG);
            $dispatcher = $this->container->taskDispatcher()->getDispatcherByTask($task);
            $result = $dispatcher->dispatch($task);

            if($result->getExitCode() > 0){
                throw new \RuntimeException("Got exit code {$result->getExitCode()} from " . get_class($task));
            }
        }
    }
}