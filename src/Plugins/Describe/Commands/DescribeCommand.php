<?php


namespace Deployee\Plugins\Describe\Commands;


use Deployee\Application\Command;
use Deployee\CollectionInterface;
use Deployee\Plugins\Deploy\Definitions\AbstractDeploymentDefinition;
use Deployee\Plugins\Deploy\Definitions\DefinitionFinder;
use Deployee\Plugins\Describe\Events\PostDescribeDeployment;
use Deployee\Plugins\Describe\Events\PreDescribeDeployment;
use Deployee\Tasks\TaskInterface;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class DescribeCommand extends Command
{
    /**
     * @inheritdoc
     */
    public function configure()
    {
        parent::configure();
        $this->setName('deployee:deploy:describe');
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $finder = new DefinitionFinder($this->container);
        $definitions = $finder->find();

        $event = new PreDescribeDeployment($this->container, $definitions);
        $this->container->events()->dispatch(PreDescribeDeployment::EVENT_NAME, $event);

        /* @var AbstractDeploymentDefinition $definition */
        foreach($definitions as $definition){
            $output->writeln("Reading definition " . get_class($definition));
            $definition->define();
            $this->describeTasks($definition->getTasks(), $output);
        }

        $event = new PostDescribeDeployment($this->container, $definitions);
        $this->container->events()->dispatch(PostDescribeDeployment::EVENT_NAME, $event);
    }

    /**
     * @param CollectionInterface $tasks
     * @param OutputInterface $output
     */
    private function describeTasks(CollectionInterface $tasks, OutputInterface $output){
        /* @var TaskInterface $task */
        foreach($tasks as $task) {
            $output->writeln("Describing task " . get_class($task), OutputInterface::VERBOSITY_DEBUG);
            $output->writeln("Describing is in development. Sorry :(");

        }
    }

}