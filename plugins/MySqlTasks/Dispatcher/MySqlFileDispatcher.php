<?php


namespace Deployee\Plugins\MySqlTasks\Dispatcher;

use Deployee\Deployment\Definitions\Tasks\TaskDefinitionInterface;
use Deployee\Plugins\MySqlTasks\Definitions\MySqlFileDefinition;
use Deployee\Plugins\MySqlTasks\Helper\Credentials;
use Deployee\Plugins\MySqlTasks\Module;
use Deployee\Plugins\RunDeploy\Dispatcher\AbstractTaskDefinitionDispatcher;
use Deployee\Plugins\ShellTasks\Definitions\ShellTaskDefinition;
use Phizzl\MySqlCommandBuilder\MySqlCommandBuilder;

class MySqlFileDispatcher extends AbstractTaskDefinitionDispatcher
{
    /**
     * @param TaskDefinitionInterface $taskDefinition
     * @return bool
     */
    public function canDispatchTaskDefinition(TaskDefinitionInterface $taskDefinition)
    {
        return $taskDefinition instanceof MySqlFileDefinition;
    }

    /**
     * @param TaskDefinitionInterface $taskDefinition
     * @return \Deployee\Plugins\RunDeploy\Dispatcher\DispatchResultInterface
     */
    public function dispatch(TaskDefinitionInterface $taskDefinition)
    {
        /* @var Credentials $credentials */
        $credentials = $this->locator->Dependency()->getDependency(Module::CREDENTIALS_DEPENDENCY);
        /* @var MySqlCommandBuilder $builder */
        $builder = $this->locator->MySqlTasks()->getFactory()->createMysqlCommandBuilder($credentials);
        $definition = $taskDefinition->define();

        if($definition->get('force') === true){
            $builder->force();
        }

        $builder->readFromFile($definition->get('source'));

        $shellTask = new ShellTaskDefinition("");
        $shellTask->arguments($builder->getCommand()->getCommand());

        return $this->delegate($shellTask);
    }
}