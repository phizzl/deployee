<?php


namespace Deployee\Plugins\Environments;


use Deployee\Application\Business\CommandCollection;
use Deployee\Dependency\DependencyInjectionProviderInterface;
use Deployee\Kernel\Locator;
use Deployee\Plugins\DescribeDeploy\Commands\DescribeDeployCommand;
use Deployee\Plugins\Environments\Subscriber\FindExecutableDefinitionsSubscriber;
use Deployee\Plugins\Environments\Subscriber\PreRunDeploySubscriber;
use Deployee\Plugins\RunDeploy\Commands\DeployRunCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputOption;

class DependencyInjectionProvider implements DependencyInjectionProviderInterface
{
    /**
     * @param Locator $locator
     */
    public function injectDependencies(Locator $locator)
    {
        $locator->Events()->getFacade()->addSubscriber(new FindExecutableDefinitionsSubscriber($locator));
        $locator->Events()->getFacade()->addSubscriber(new PreRunDeploySubscriber($locator));

        $locator->Dependency()->getFacade()->extendDependency(
            \Deployee\Application\Module::COMMAND_COLLECTION_DEPENDENCY,
            function (CommandCollection $collection){
                /* @var Command $command */
                foreach($collection->getCommands() as $command){
                    if($command instanceof DeployRunCommand
                        || $command instanceof DescribeDeployCommand){
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