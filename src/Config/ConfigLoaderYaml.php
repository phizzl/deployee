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

        if(isset($config['plugins'])) {
            $config['plugins'] = $this->mergePluginConfiguration($defaultConfig['plugins'], $config['plugins']);
            unset($defaultConfig['plugins']);
        }

        return array_merge($defaultConfig, $config);
    }

    /**
     * @param array $array1
     * @param array $array2
     * @return array
     */
    private function mergePluginConfiguration(array $array1, array $array2)
    {
        $return = [];
        $configs = array_merge(
            $this->normalizePluginConfigurationArray($array1),
            $this->normalizePluginConfigurationArray($array2)
        );

        foreach($configs as $key => $item){
            if(strlen($key)) {
                $return[] = [$key => $item];
            }
        }

        return $return;
    }

    /**
     * @param array $array
     * @return array
     */
    private function normalizePluginConfigurationArray(array $array)
    {
        $return = [];
        foreach($array as $item){
            if(is_array($item)) {
                $return[current(array_keys($item))] = current(array_values($item));
            }
            else {
                $return[$item] = [];
            }
        }
        return $return;
    }
}