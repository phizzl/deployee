<?php


namespace Phizzl\Deployee\Plugins\Deploy\Commands;


use Phizzl\Deployee\Application\Command;
use Phizzl\Deployee\CollectionInterface;
use Phizzl\Deployee\Plugins\Deploy\Definitions\DefinitionFinder;
use Phizzl\Deployee\Plugins\Deploy\Definitions\DeploymentDefinitionInterface;
use Phizzl\Deployee\Plugins\Deploy\Events\PreRunDeployEvent;
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

        /* @var DeploymentDefinitionInterface $definition */
        foreach($definitions as $definition){
            $output->writeln("Executing definition " . get_class($definition));
            $this->runTasks($definition->getTasks());
        }
    }

    private function runTasks(CollectionInterface $tasks){

    }
}