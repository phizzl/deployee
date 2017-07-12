<?php


namespace Deployee\Plugins\Deploy\Definitions;


use Deployee\Container;
use Deployee\Plugins\Deploy\DeployPlugin;
use Symfony\Component\Finder\Finder;

class DefinitionFinder
{
    /**
     * @var Container
     */
    private $container;

    /**
     * DefinitionFinder constructor.
     * @param Container $container
     */
    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    /**
     * @return DefinitionCollection
     */
    public function find()
    {
        $return = new DefinitionCollection();
        /* @var DeployPlugin $plugin */
        $plugin = $this->container->plugins()->offsetGet(DeployPlugin::PLUGIN_ID);
        $finder = new Finder();
        $finder
            ->files()
            ->name("DeployDefinition_*.php")
            ->depth(0)
            ->sortByName()
            ->in([$plugin->getConfig()['path']]);

        foreach($finder as $file){
            $filename = basename($file->getRealPath());
            $classname = substr($filename, 0, strrpos($filename, '.'));

            if(!class_exists($classname)){
                $this->addClassMap($classname, $file->getRealPath());
            }

            /* @var DeploymentDefinitionInterface $definition */
            $definition = new $classname($this->container);
            $return[] = $definition;
        }

        return $return;
    }

    /**
     * @param string $class
     * @param string $filepath
     */
    private function addClassMap($class, $filepath)
    {
        $this->container->classLoader()->addClassMap([$class => $filepath]);
    }
}