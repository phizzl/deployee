<?php


namespace Deployee\Config;


use Symfony\Component\Yaml\Yaml;

class ConfigLoaderYaml implements ConfigLoaderInterface
{
    /**
     * @var string
     */
    private $configFile;

    /**
     * @var string
     */
    private $defaultConfigFile;

    /**
     * ConfigLoaderYaml constructor.
     * @param string $configFile
     */
    public function __construct($configFile, $defaultConfigFile)
    {
        $this->configFile = $configFile;
        $this->defaultConfigFile = $defaultConfigFile;
    }

    /**
     * @return array
     */
    public function load()
    {
        if(!is_file($this->configFile)
            || !is_readable($this->configFile)){
            throw new \RuntimeException("Deployee config file could not be read from \"{$this->configFile}\"");
        }

        if(!($config = Yaml::parse(file_get_contents($this->configFile)))
            || !is_array($config)){
            throw new \RuntimeException("Config file could not be parsed or has invalid contents");
        }

        if(!($defaultConfig = Yaml::parse(file_get_contents($this->defaultConfigFile)))
            || !is_array($defaultConfig)){
            throw new \RuntimeException("Default config file could not be parsed or has invalid contents");
        }

        return array_merge_recursive($defaultConfig, $config);
    }
}