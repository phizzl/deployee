<?php


namespace Deployee\Plugins\Deploy\Commands;


use Deployee\Application\Command;
use Deployee\Plugins\Deploy\DeployPlugin;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class GenerateDeployCommand extends Command
{
    /**
     * @inheritdoc
     */
    public function configure()
    {
        parent::configure();
        $this
            ->setName('deployee:deploy:generate')
            ->addArgument("name", InputArgument::OPTIONAL, '', uniqid());
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $name = $input->getArgument('name');
        $className = "DeployDefinition_" . time() . "_" . $name;
        $plugin = $this->container->plugins()->offsetGet(DeployPlugin::PLUGIN_ID);
        $filePath = $plugin->getConfig()['path'] . DIRECTORY_SEPARATOR . $className . '.php';
        $fileContents = $this->getPhpFileSkeleton($className);

        if(!file_put_contents($filePath, $fileContents)){
            throw new \RuntimeException("File could ne be generated!");
        }

        $output->writeln("Generated file \"$filePath\"");
    }

    /**
     * @param string $className
     * @return string
     */
    private function getPhpFileSkeleton($className)
    {
        return <<<EOL
<?php

/**
 * @mixin ideHelperDeploymentDefinition
 */
class $className extends \\Deployee\\Plugins\\Deploy\\Definitions\\AbstractDeploymentDefinition
{
    public function define()
    {
        // Start adding your tasks here
    }
}
EOL;
    }
}