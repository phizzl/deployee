<?php


namespace Deployee\Plugins\MySqlTasks;


use Deployee\Kernel\Modules\AbstractFactory;
use Deployee\Plugins\MySqlTasks\Helper\Credentials;
use Deployee\Plugins\ShellTasks\Helper\ExecutableFinder;
use Phizzl\MySqlCommandBuilder\MySqlCommandBuilder;

class Factory extends AbstractFactory
{
    /**
     * @return Credentials
     */
    public function createCredentials()
    {
        /* @var \Deployee\Config\Facade $config */
        $config = $this->locator->Config()->getFacade();
        $credentials = new Credentials();

        if($config->get('mysql.host')){
            $credentials->setHost($config->get('mysql.host'));
        }

        if($config->get('mysql.port')){
            $credentials->setPort($config->get('mysql.port'));
        }

        if($config->get('mysql.username')){
            $credentials->setUsername($config->get('mysql.username'));
        }

        if($config->get('mysql.password')){
            $credentials->setPassword($config->get('mysql.password'));
        }

        if($config->get('mysql.database')){
            $credentials->setPassword($config->get('mysql.database'));
        }

        return $credentials;
    }

    /**
     * @param Credentials $credentials
     * @return MySqlCommandBuilder
     */
    public function createMysqlCommandBuilder(Credentials $credentials)
    {
        if(!$credentials->getDatabase()){
            throw new \InvalidArgumentException("You must specify mysql database at least!");
        }
        /* @var \Deployee\Config\Facade $config */
        $config = $this->locator->Config()->getFacade();
        /* @var ExecutableFinder $finder */
        $finder = $this->locator->Dependency()->getDependency(\Deployee\Plugins\ShellTasks\Module::EXECUTABLE_FINDER_DEPENDENCY);
        $mysqlBin = $config->get('mysql.bin') ? $config->get('mysql.bin') : $finder->find('mysql');

        $builder = new MySqlCommandBuilder($credentials->getDatabase());
        $builder->mysqlBin($mysqlBin);

        if($credentials->getHost()){
            $builder->host($credentials->getHost());
        }

        if($credentials->getPort()){
            $builder->port($credentials->getPort());
        }

        if($credentials->getUsername()){
            $builder->user($credentials->getUsername());
        }

        if($credentials->getPassword()){
            $builder->password($credentials->getPassword());
        }

        return $builder;
    }
}