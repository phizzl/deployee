<?php

namespace Deployee\Config;


use Deployee\Kernel\Modules\AbstractFacade;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Yaml\Yaml;

class Facade extends AbstractFacade
{
    /**
     * @var Config
     */
    private $config;

    /**
     * @param string $name
     * @param null $default
     * @return mixed
     */
    public function get($name, $default = null)
    {
        return $this->getConfigObject()->get($name, $default);
    }

    /**
     * @return Config
     */
    private function getConfigObject()
    {
        if($this->config === null){
            $configFile = $this->findConfigFile();
            if(!$params = Yaml::parse(file_get_contents($configFile))){
                throw new \RuntimeException("Could not parse config file \"{$configFile}\"");
            }

            $params['deployee.confdir'] = dirname($configFile);
            $params['deployee.cwd'] = getcwd();

            $this->config = $this->locator->Config()->getFactory()->createConfig($params);
        }

        return $this->config;
    }

    /**
     * @return string
     */
    private function findConfigFile()
    {
        $searchInPaths = [getcwd()];

        if($envConfig = getenv('DEPLOYEE_CONFIG')){
            $envConfig = is_file($envConfig) ? dirname($envConfig) : $envConfig;
            array_unshift($searchInPaths, $envConfig);
        }

        $finder = new Finder();
        $finder
            ->name("deployee.yml")
            ->depth("< 1")
            ->in($searchInPaths);

        foreach($finder as $fileInfo){
            return $fileInfo->getRealPath();
        }

        throw new \RuntimeException("Could not locate deployee.yml");
    }
}