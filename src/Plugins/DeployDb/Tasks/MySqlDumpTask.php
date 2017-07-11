<?php


namespace Phizzl\Deployee\Plugins\DeployDb\Tasks;


use Phizzl\Deployee\Collection;
use Phizzl\Deployee\Tasks\TaskInterface;

class MySqlDumpTask implements TaskInterface
{
    /**
     * @var string
     */
    private $target;

    /**
     * @var bool
     */
    private $force;

    /**
     * @var bool
     */
    private $noCreateInfo;

    /**
     * @var bool
     */
    private $noData;

    /**
     * @var array
     */
    private $includeTables;

    /**
     * @var array
     */
    private $excludeTables;

    /**
     * MySqlDumpTask constructor.
     * @param $target
     */
    public function __construct($target)
    {
        $this->target = $target;
        $this->arguments = "";
        $this->force = false;
        $this->noCreateInfo = false;
        $this->noData = false;
        $this->includeTables = [];
        $this->excludeTables = [];
    }

    /**
     * @return $this
     */
    public function force()
    {
        $this->force = true;
        return $this;
    }

    /**
     * @return $this
     */
    public function noCreateInfo()
    {
        $this->noCreateInfo = true;
        return $this;
    }

    /**
     * @return $this
     */
    public function noData()
    {
        $this->noData = true;
        return $this;
    }

    /**
     * @param string $table
     * @return $this
     */
    public function includeTable($table)
    {
        $this->includeTables[$table] = $table;
        return $this;
    }

    /**
     * @param string $table
     * @return mixed
     */
    public function excludeTable($table)
    {
        $this->excludeTables[$table] = $table;
        return $table;
    }

    /**
     * @return Collection
     */
    public function getDefinition()
    {
        return new Collection([
            'target' => $this->target,
            'force' => $this->force,
            'nocreateinfo' => $this->noCreateInfo,
            'nodata' => $this->noData,
            'includetables' => $this->includeTables,
            'excludeTables' => $this->excludeTables
        ]);
    }

}