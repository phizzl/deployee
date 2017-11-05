<?php


namespace Deployee\Plugins\Pdo;

use Deployee\Kernel\Modules\AbstractFacade;

class Facade extends AbstractFacade
{
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