<?php


namespace Deployee\Plugins\DeployDb\Tasks;


use Deployee\Collection;
use Deployee\Tasks\TaskInterface;

class MySqlFileImportTask implements TaskInterface
{
    /**
     * @var string
     */
    private $source;

    /**
     * @var bool
     */
    private $force;

    /**
     * MySqlDumpTask constructor.
     * @param $target
     */
    public function __construct($source)
    {
        $this->source = $source;
        $this->force = false;
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
     * @return Collection
     */
    public function getDefinition()
    {
        return new Collection([
            'source' => $this->source,
            'force' => $this->force
        ]);
    }

}