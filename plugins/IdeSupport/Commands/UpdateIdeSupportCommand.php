<?php

namespace Deployee\Plugins\IdeSupport\Commands;


use Deployee\Application\Business\Command;
use Deployee\Deployment\Helper\TaskCreationHelper;
use Deployee\Deployment\Module;
use Deployee\Kernel\Exceptions\ClassNotFoundException;
use Deployee\Kernel\Exceptions\ModuleNotFoundException;
use Deployee\Kernel\Modules\ModuleInterface;
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
        $definitionSupport = $this->generateDeploymentDefinitionSupportClass();
        $locatorSupport = $this->generateLocatorSupportClass();

        $targetFile = getcwd() . '/.deployee_ide_helper.php';
        $contents = <<<EOL
<?php
{$definitionSupport}

{$locatorSupport}
EOL;

        file_put_contents($targetFile, $contents);
        $output->writeln(sprintf("Generated helper classes to file %s", $targetFile));
    }

    /**
     * @param array $foundModules
     * @return string
     */
    private function generateFacadeAndFactorySupportClasses(array $foundModules)
    {
        $classes = [];
        /* @var ModuleInterface $module */
        foreach($foundModules as $name => $module){
            $methods = [];
            if($factory = $module->getFactory()){
                $factoryClass = get_class($factory);
                $methods[] = <<<EOL
    /**
     * @return {$factoryClass}
     */
    public function getFactory()
    {
        return new {$factoryClass}();
    }
EOL;
            }

            $facadeClass = get_class($module->getFacade());
            $methods[] = <<<EOL
    /**
     * @return {$facadeClass}
     */
    public function getFacade()
    {
        return new {$facadeClass}();
    }
EOL;
            $methods = implode(PHP_EOL.PHP_EOL, $methods);
            $moduleClass = get_class($module);
            $generatedModuleClass = str_replace("\\", '_', $moduleClass) . "_{$name}_Generated";
            $classes[] = <<<EOL
/**
 * This class was generated
 */
class {$generatedModuleClass} extends {$moduleClass}
{
{$methods}
}
EOL;

        }

        return implode(PHP_EOL.PHP_EOL, $classes);
    }

    /**
     * @return string
     */
    private function generateLocatorSupportClass()
    {
        $methods = [];
        $foundModules = [];
        foreach($this->locator->ClassLoader()->getFacade()->getPrefixesPsr4() as $prefixes){
            foreach($prefixes as $prefix){
                foreach(new \DirectoryIterator($prefix) as $item){
                    if(!$item->isDir() || $item->isDot()){
                        continue;
                    }

                    try{
                        $module = call_user_func_array([$this->locator, $item->getBasename()], []);
                        $returnClass = str_replace("\\", '_', get_class($module)) . "_{$item->getBasename()}_Generated";
                        $foundModules[$item->getBasename()] = $module;
                        $methods[] = <<<EOL
    /**
     * @return {$returnClass}
     */
    public function {$item->getBasename()}()
    {
        return new {$returnClass}();
    }
EOL;

                    }
                    catch(ModuleNotFoundException $e){}
                    catch(ClassNotFoundException $e){}
                }
            }
        }

        $facadeAndFactorySupport = $this->generateFacadeAndFactorySupportClasses($foundModules);

        $methods = implode(PHP_EOL.PHP_EOL, $methods);
        return <<<EOL
/**
 * This class was generated
 */
abstract class GeneratedDeployeeIdeSupportLocator
{
{$methods}
}

{$facadeAndFactorySupport}
EOL;

    }

    /**
     * Generate helper class for deployment definitions
     * @return string
     */
    private function generateDeploymentDefinitionSupportClass()
    {
        /* @var TaskCreationHelper $taskHelper */
        $taskHelper = $this->locator->Dependency()->getFacade()->getDependency(Module::DEFINITION_HELPER_TASK_CREATION_DEPENDENCY);

        $alias = $taskHelper->getAllAlias();
        $helperMethods = [];

        foreach($alias as $helperName => $aliasDefinition){
            $signatur = implode(", ", $this->getClassConstructorSignatur($aliasDefinition['class']));
            $helperMethods[] = <<<EOL
    /**
     * @return {$aliasDefinition['class']}
     */
    public function {$aliasDefinition['alias']}({$signatur})
    {
        return new {$aliasDefinition['class']}({$signatur});
    }
EOL;
        }

        $helperMethods = implode(PHP_EOL . PHP_EOL, $helperMethods);

        return <<<EOL
/**
 * This class was generated
 */
abstract class GeneratedDeployeeIdeSupportDefinitions
{
    {$helperMethods}
}

/**
 * Backwards compatibility v0.1
 * @deprecated
 */
class ideHelperDeploymentDefinition extends GeneratedDeployeeIdeSupportDefinitions {}
EOL;
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
                $defaultValue = var_export($parameter->getDefaultValue(), true);
            }

            $signatur[] = "\$" . $parameter->getName() . ($parameter->isOptional() ? " = {$defaultValue}" : "");
        }

        return $signatur;
    }
}