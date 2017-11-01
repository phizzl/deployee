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
                $sortNameA = substr($a->getBasename(), strpos($a->getBasename(), '_')+1);
                $sortNameB = substr($b->getBasename(), strpos($b->getBasename(), '_')+1);
                return strcmp($sortNameA, $sortNameB);
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