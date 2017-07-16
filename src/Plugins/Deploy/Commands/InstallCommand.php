<?php


namespace Deployee\Plugins\Deploy\Commands;


use Deployee\Application\Command;
use Deployee\Plugins\Deploy\Events\InstallEvent;
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
        $this
            ->setName('deployee:install');
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        parent::execute($input, $output);

        $this->container->events()->dispatch(
            InstallEvent::EVENT_NAME,
            new InstallEvent($this->container, $input, $output)
        );
    }
}