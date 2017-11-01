<?php

namespace Deployee\Deployment\Finder;


use Symfony\Component\Finder\Finder;

class DeploymentDefinitionClassMapFinder
{
    /**
     * @var string
     */
    private $basepath;

    /**
     * @var Finder
     */
    private $finder;

    /**
     * DeploymentDefinitionFinder constructor.
     * @param string $basepath
     */
    public function __construct($basepath)
    {
        $this->basepath = $basepath;
        $this->finder = new Finder();
    }

    /**
     * @return array
     */
    public function getClassMap()
    {
        $this->finder
            ->files()
            ->name('/^(DeployDefinition\_|Deploy\_).*\.php$/')
            ->depth("<= 1")
            ->sort(function(\SplFileInfo $a, \SplFileInfo $b){
                return strcmp($a->getBasename(), $b->getBasename());
            })
            ->in([$this->basepath]);

        $classMap = [];
        foreach($this->finder as $file){
            $filename = basename($file->getRealPath());
            $classname = substr($filename, 0, strrpos($filename, '.'));

            $classMap[$classname] = $file->getRealPath();
        }

        return $classMap;
    }
}