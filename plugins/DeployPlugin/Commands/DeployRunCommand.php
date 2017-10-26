<?php

namespace Deployee\Plugins\DeployPlugin\Commands;


use Deployee\Application\Business\Command;
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
        $output->writeln("TEST");
    }
}