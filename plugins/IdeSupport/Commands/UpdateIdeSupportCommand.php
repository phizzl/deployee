<?php

namespace Deployee\Plugins\IdeSupport\Commands;


use Deployee\Application\Business\Command;
use Deployee\Deployment\Helper\TaskCreationHelper;
use Deployee\Deployment\Module;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class UpdateIdeSupportCommand extends Command
{
    /**
     * @inheritdoc
     */
    public function configure()
    {
        parent::configure();
        $this->setName('deployee:ide-support:generate');
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->generateDeploymentDefinitionSupportClass();
    }

    /**
     * Generate helper class for deployment definitions
     */
    private function generateDeploymentDefinitionSupportClass()
    {
        /* @var TaskCreationHelper $taskHelper */
        $taskHelper = $this->locator->Dependency()->getDependency(Module::DEFINITION_HELPER_TASK_CREATION_DEPENDENCY);

        $alias = $taskHelper->getAllAlias();
        $helperMethods = [];

        foreach($alias as $helperName => $className){
            $signatur = implode(", ", $this->getClassConstructorSignatur($className));
            $helperMethods[] = <<<EOL
    /**
     * @return {$className}
     */
    public function {$helperName}({$signatur})
    {
        return new {$className}({$signatur});
    }
EOL;
        }

        $helperMethods = implode(PHP_EOL . PHP_EOL, $helperMethods);

        $classTemplate = <<<EOL
<?php

class GeneratedDeployeeIdeSupportDefinitions
{
    {$helperMethods}
}

/**
 * Backwards compatibility v0.1
 * @deprecated
 */
class ideHelperDeploymentDefinition extends GeneratedDeployeeIdeSupportDefinitions {}
EOL;

        file_put_contents(getcwd() . '/.deployee_ide_helper.php', $classTemplate);
    }

    /**
     * @param string $className
     * @return array
     */
    private function getClassConstructorSignatur($className)
    {
        $refection = new \ReflectionClass($className);
        if(!$refection->getConstructor()){
            return [];
        }

        $signatur = [];
        /* @var \ReflectionParameter $parameter */
        foreach($refection->getConstructor()->getParameters() as $parameter){
            $defaultValue = "";

            if($parameter->isOptional()){
                if(is_string($parameter->getDefaultValue())){
                    $defaultValue = "\"{$parameter->getDefaultValue()}\"";
                }
                else{
                    $defaultValue = $parameter->getDefaultValue();
                }
            }

            $signatur[] = "\$" . $parameter->getName() . ($parameter->isOptional() ? " = {$defaultValue}" : "");
        }

        return $signatur;
    }
}