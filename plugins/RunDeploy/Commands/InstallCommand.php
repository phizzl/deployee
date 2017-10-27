<?php

namespace Deployee\Plugins\RunDeploy\Commands;


use Deployee\Application\Business\Command;
use Deployee\Plugins\RunDeploy\Events\RunInstallCommandEvent;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class InstallCommand extends Command
{
    /**
     * @inheritdoc
     */
    public function configure()
    {
        parent::configure();
        $this->setName('deployee:install');
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln('Running install');

        $deploymentPath = $this->locator->Config()->getFacade()->get('deployment_path', 'deployments');
        if(!is_dir($deploymentPath)){
            $output->writeln("Create directory \"{$deploymentPath}\"");

        }

        $event = new RunInstallCommandEvent();
        $this->locator->Events()->getFacade()->dispatchEvent(RunInstallCommandEvent::class, $event);

        $output->writeln('Finished installing');
    }
}