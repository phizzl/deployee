<?php


namespace Deployee\Bootstrap;

use Deployee\Config\Config;
use Deployee\Config\ConfigLoaderInterface;
use Deployee\Config\ConfigLoaderYaml;
use Deployee\Container;

/**
 * @mixin Bootstrap
 */
trait RegisterConfigTrait
{
    /**
     * Register the config loader to the DI container
     */
    private function registerConfigLoader()
    {
        /**
         * @return ConfigLoaderInterface
         */
        $this->getContainer()[ConfigLoaderInterface::CONTAINER_ID] = function(Container $container){
            $defaultConfigFile = __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'deployee.dist.yml';
            $find = [
                getcwd() . DIRECTORY_SEPARATOR . 'deployee.yml',
                getcwd() . DIRECTORY_SEPARATOR . 'deployee.dist.yml',
                __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'deployee.dist.yml'
            ];

            /* @var BootstrapArguments $bootstrapArguments */
            $bootstrapArguments = $container[BootstrapArguments::CONATINER_ID];
            if($env = $bootstrapArguments->getOption('env')){
                array_unshift($find, getcwd() . DIRECTORY_SEPARATOR . "deployee.{$env}.yml");
            }

            if($envConfig = getenv("DEPLOYEE_CONFIG")){
                array_unshift($find, $envConfig);
            }

            $file = '';
            foreach($find as $findFile){
                if(is_file($findFile)
                    && is_readable($findFile)){
                    $file = $findFile;
                    break;
                }
            }

            $config = new ConfigLoaderYaml($file, $defaultConfigFile);
            $config['loaded_env'] = $env;

            return $config;
        };
    }

    /**
     * Register the config to the DI container
     */
    private function registerConfig()
    {
        /**
         * @param Container $di
         * @return Config
         */
        $this->getContainer()[Config::CONTAINER_ID] = function(Container $di){
            /* @var ConfigLoaderInterface $loader */
            $loader = $di[ConfigLoaderInterface::CONTAINER_ID];
            $params = $loader->load();
            $config = new Config();
            $config->setParams($params);
            return $config;
        };
    }
}