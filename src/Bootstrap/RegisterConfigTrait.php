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
        $this->getContainer()[ConfigLoaderInterface::CONTAINER_ID] = function(){
            $defaultConfigFile = __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'deployee.dist.yml';
            $find = [
                getcwd() . DIRECTORY_SEPARATOR . 'deployee.yml',
                getcwd() . DIRECTORY_SEPARATOR . 'deployee.dist.yml',
                __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'deployee.dist.yml'
            ];

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

            return new ConfigLoaderYaml($file, $defaultConfigFile);
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