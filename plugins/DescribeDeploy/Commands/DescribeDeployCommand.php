<?php

namespace Deployee\Plugins\DescribeDeploy\Commands;


use Deployee\Application\Business\Command;
use Deployee\Deployment\Definitions\Deployments\DeploymentDefinitionInterface;
use Deployee\Deployment\Definitions\Tasks\TaskDefinitionInterface;
use Deployee\Plugins\DescribeDeploy\Descriptor\Descriptor;
use Deployee\Plugins\DescribeDeploy\Descriptor\MarkdownFormat;
use Deployee\Plugins\i18n\Facade;
use Deployee\Plugins\i18n\Module;
use Deployee\Plugins\RunDeploy\Events\FindExecutableDefinitionsEvent;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class DescribeDeployCommand extends Command
{
    /**
     * @inheritdoc
     */
    public function configure()
    {
        parent::configure();
        $this->setName('deployee:deploy:describe');
        $this->addOption('lang', null, InputOption::VALUE_OPTIONAL, 'the language', Module::LANG_US_EN);
        $this->addOption('file', null, InputOption::VALUE_OPTIONAL, 'a file to write the output to');
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $lang = $input->getOption('lang');
        $file = $input->getOption('file');
        $definitions = $this->getExecutableDefinitions($input);
        $descriptor = new Descriptor(new MarkdownFormat());
        foreach($definitions as $className){
            $deployment = $this->locator->Deployment()->getFactory()->createDeploymentDefinition($className);
            $this->describeDeploymentDefinition($descriptor, $lang, $deployment, $output);
        }

        if($file !== null){
            file_put_contents($file, $descriptor->printContents());
            $output->writeln("Wrote description to {$file}");
        }
        else {
            echo $descriptor->printContents();
        }
    }

    /**
     * @param string $lang
     * @param DeploymentDefinitionInterface $deployment
     * @param OutputInterface $output
     */
    private function describeDeploymentDefinition(Descriptor $descriptor, $lang, DeploymentDefinitionInterface $deployment, OutputInterface $output)
    {
        /* @var Facade $i18n */
        $i18n = $this->locator->i18n()->getFacade();
        $deployment->define();

        $descriptor->addDefinitionTitle($i18n->translate($lang, "describe.definition.headline", ['CLASSNAME' => get_class($deployment)]));

        /* @var TaskDefinitionInterface $taskDefinition */
        foreach($deployment->getTaskDefinitions()->toArray() as $taskDefinition){
            $this->describeTaskDefinition($descriptor, $lang, $taskDefinition, $output);
        }
    }

    /**
     * @param string $lang
     * @param TaskDefinitionInterface $taskDefinition
     * @param OutputInterface $output
     */
    private function describeTaskDefinition(Descriptor $descriptor, $lang, TaskDefinitionInterface $taskDefinition, OutputInterface $output)
    {
        /* @var Facade $i18n */
        $i18n = $this->locator->i18n()->getFacade();
        $langKey = "task." . strtolower(get_class($taskDefinition));

        // TODO: Add logic for describing tasks. Maybe with own describer classes (like dispatcher)
    }

    /**
     * @return array
     */
    private function getExecutableDefinitions(InputInterface $input)
    {
        $deploymentDefinitions = $this->locator->Deployment()->findDeploymentDefinitions();
        $event = new FindExecutableDefinitionsEvent($deploymentDefinitions, $input);
        $this->locator->Events()->dispatchEvent(FindExecutableDefinitionsEvent::class, $event);
        return $event->getDefinitions();
    }
}