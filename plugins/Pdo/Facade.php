<?php


namespace Deployee\Plugins\Pdo;

use Deployee\Kernel\Modules\AbstractFacade;

class Facade extends AbstractFacade
{
    /**
     * @param string $sql
     * @param array $params
     * @return bool
     */
    public function execute($sql, array $params = [])
    {
        $pdo = $this->getPdo();
        $stmt = $pdo->prepare($sql);
        $stmt->execute($params);

        return true;
    }

    /**
     * @param string $sql
     * @param array $params
     * @return mixed|null
     */
    public function selectOne($sql, array $params = [])
    {
        $row = $this->selectOneRow($sql, $params, \PDO::FETCH_NUM);
        return count($row) ? current($row) : null;
    }

    /**
     * @param string $sql
     * @param array $params
     * @param int $fetchMode
     * @return array|null
     */
    public function selectOneRow($sql, array $params = [], $fetchMode = \PDO::FETCH_ASSOC)
    {
        $pdo = $this->getPdo();
        $stmt = $pdo->prepare($sql);
        $stmt->execute($params);

        return $stmt->fetch($fetchMode);
    }

    /**
     * @param string $sql
     * @param array $params
     * @param int $fetchMode
     * @return array
     */
    public function select($sql, array $params = [], $fetchMode = \PDO::FETCH_ASSOC)
    {
        $pdo = $this->getPdo();
        $stmt = $pdo->prepare($sql);
        $stmt->execute($params);

        return $stmt->fetchAll($fetchMode);
    }

    /**
     * @return \PDO
     */
    private function getPdo()
    {
        return $this->locator->Dependency()->getDependency(Module::PDO_DEPENDENCY);
    }
}