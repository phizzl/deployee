<?php


namespace Phizzl\Deployee\Plugins\Deploy\Commands;


use Phizzl\Deployee\Application\Command;
use Phizzl\Deployee\CollectionInterface;
use Phizzl\Deployee\Dispatcher\TaskDispatcherInterface;
use Phizzl\Deployee\Plugins\Deploy\Definitions\AbstractDeploymentDefinition;
use Phizzl\Deployee\Plugins\Deploy\Definitions\DefinitionFinder;
use Phizzl\Deployee\Plugins\Deploy\Events\PreRunDeployEvent;
use Phizzl\Deployee\Tasks\TaskInterface;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class RunDeployCommand extends Command
{
    use SetPluginTrait;

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
    }


    private function runTasks(CollectionInterface $tasks, OutputInterface $output){
        /* @var TaskInterface $task */
        foreach($tasks as $task) {
            $output->writeln("Executing task " . get_class($task), OutputInterface::VERBOSITY_DEBUG);
            $dispatcher = $this->getDispatcherForTask($task);
            $dispatcher->disptach($task);
        }
    }

    /**
     * @param TaskInterface $task
     * @return TaskDispatcherInterface
     */
    private function getDispatcherForTask(TaskInterface $task)
    {
        /* @var TaskDispatcherInterface $taskDispatcher */
        foreach($this->container->taskDispatcher() as $taskDispatcher){
            if($taskDispatcher->canDispatch($task)){
                return $taskDispatcher;
            }
        }

        throw new \RuntimeException("No dispatcher defined for task " . get_class($task));
    }
}