<?php

namespace Deployee\Plugins\GenerateDeploy\Commands;


use Deployee\Application\Business\Command;
use Deployee\Deployment\Helper\TaskCreationHelper;
use Deployee\Deployment\Module;
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
            ->addArgument("name", InputArgument::OPTIONAL, '', uniqid()
        );
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $name = $input->getArgument('name');
        $className = "Deploy_" . time() . "_" . $name;
        $className = str_replace(["-", " "], "_", $className);
        $filePath = $this->locator->Config()->get('definition_path') . "/{$className}.php";
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

use Deployee\\Deployment\\Definitions\\Deployments\\AbstractDeployment;

/**
 * @mixin \DeployeeIdeSupportDefinitions
 */
class $className extends AbstractDeployment
{
    public function define()
    {
        // Start adding your tasks here
    }
}
EOL;
    }
}