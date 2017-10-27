<?php


namespace Deployee\Plugins\DeployHistory\Storages;


use Deployee\Plugins\Deploy\Definitions\DeploymentDefinitionInterface;

class MySqlDefinitionStorage implements DefinitionStorageInterface
{
    /**
     * @var string
     */
    private $host;

    /**
     * @var int
     */
    private $port;

    /**
     * @var string
     */
    private $user;

    /**
     * @var string
     */
    private $password;

    /**
     * @var string
     */
    private $dbname;

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
        $this->host = $host;
        $this->port = $port;
        $this->user = $user;
        $this->password = $password;
        $this->dbname = $dbname;
    }

    /**
     * @return \PDO
     */
    private function pdo()
    {
        if($this->pdo === null){
            $this->pdo = new \PDO("mysql:host={$this->host};port={$this->port};dbname={$this->dbname}",
                $this->user,
                $this->password,
                [\PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION]
            );
        }

        return $this->pdo;
    }

    /**
     * @inheritdoc
     */
    public function setup()
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

        $this->pdo()->exec($sql);
    }

    /**
     * @param DeploymentDefinitionInterface $definition
     * @return bool
     */
    public function isStored(DeploymentDefinitionInterface $definition)
    {
        $sql = "SELECT COUNT(*) FROM `deployee_history` WHERE `name`=?";
        $statement = $this->pdo()->prepare($sql);
        $statement->execute([get_class($definition)]);
        return (bool)$statement->fetchColumn();
    }

    /**
     * @param DeploymentDefinitionInterface $definition
     */
    public function store(DeploymentDefinitionInterface $definition)
    {
        $sql = "INSERT INTO `deployee_history` (`name`, `deploytime`) VALUES (?, NOW())";
        $statement = $this->pdo()->prepare($sql);
        $statement->execute([get_class($definition)]);
    }
}