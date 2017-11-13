<?php


namespace Deployee\Plugins\Environments;


use Deployee\Application\Business\CommandCollection;
use Deployee\Dependency\DependencyInjectionProviderInterface;
use Deployee\Kernel\Locator;
use Deployee\Plugins\Deploy\Commands\RunDeployCommand;
use Deployee\Plugins\Environments\Subscriber\FindExecutableDefinitionsSubscriber;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputOption;

class DependencyInjectionProvider implements DependencyInjectionProviderInterface
{
    /**
     * @param Locator $locator
     */
    public function injectDependencies(Locator $locator)
    {

        $locator->Events()->addSubscriber(new FindExecutableDefinitionsSubscriber($locator));
        $locator->Dependency()->extendDependency(
            \Deployee\Application\Module::COMMAND_COLLECTION_DEPENDENCY,
            function (CommandCollection $collection){
                /* @var Command $command */
                foreach($collection->getCommands() as $command){
                    if($command instanceof RunDeployCommand){
                        $command->addOption(
                            'env',
                            null,
                            InputOption::VALUE_OPTIONAL,
                            'The current environment'
                        );
                    }
                }
                return $collection;
            }
        );
    }
}