<?php


namespace Phizzl\Deployee\Plugins\DeployHistory\Storages;


use Phizzl\Deployee\Plugins\Deploy\Definitions\DeploymentDefinitionInterface;

class MySqlDefinitionStorage implements DefinitionStorageInterface
{
    /**
     * @var \PDO
     */
    private $pdo;

    /**
     * MySqlDefinitionStorage constructor.
     * @param string $host
     * @param int $port
     * @param string $user
     * @param string $password
     * @param string $dbname
     */
    public function __construct($host, $port, $user, $password, $dbname)
    {
        $this->pdo = new \PDO("mysql:host=$host;port=$port;dbname=$dbname", $user, $password, [
            \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION
        ]);
        $this->setup();
    }

    private function setup()
    {
        $sql = <<<SQL
CREATE TABLE IF NOT EXISTS `deployee_history` (
	`name` CHAR(255) NOT NULL,
	`deploytime` DATETIME NOT NULL,
	PRIMARY KEY (`name`)
)
COLLATE='utf8_general_ci'
ENGINE=InnoDB;
SQL;

        $this->pdo->exec($sql);
    }

    /**
     * @param DeploymentDefinitionInterface $definition
     * @return bool
     */
    public function isStored(DeploymentDefinitionInterface $definition)
    {
        $sql = "SELECT COUNT(*) FROM `deployee_history` WHERE `name`=?";
        $statement = $this->pdo->prepare($sql);
        $statement->execute([get_class($definition)]);
        return (bool)$statement->fetchColumn();
    }

    /**
     * @param DeploymentDefinitionInterface $definition
     */
    public function store(DeploymentDefinitionInterface $definition)
    {
        $sql = "INSERT INTO `deployee_history` (`name`, `deploytime`) VALUES (?, NOW())";
        $statement = $this->pdo->prepare($sql);
        $statement->execute([get_class($definition)]);
    }
}