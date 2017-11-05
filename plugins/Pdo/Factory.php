<?php

namespace Deployee\Plugins\Pdo;


use Deployee\Kernel\Modules\AbstractFactory;
use Deployee\Plugins\MySqlTasks\Helper\Credentials;

class Factory extends AbstractFactory
{
    /**
     * @param Credentials $credentials
     * @return \PDO
     */
    public function createPdo(Credentials $credentials)
    {
        $host = $credentials->getHost();
        $port = $credentials->getPort() ? $credentials->getPort() : 3306;
        $username = $credentials->getUsername();
        $password = $credentials->getPassword();
        $database = $credentials->getDatabase();

        $pdo = new \PDO("mysql:host={$host};port={$port};dbname={$database}", $username, $password, [
            \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION
        ]);

        return $pdo;
    }
}