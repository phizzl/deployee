<?php


namespace Deployee\Plugins\DeployDb\Tasks;


use Deployee\Collection;
use Deployee\Tasks\TaskInterface;

class MySqlExecuteCommandTask implements TaskInterface
{
    /**
     * @var string
     */
    private $command;

    /**
     * @var bool
     */
    private $force;

    /**
     * MySqlDumpTask constructor.
     * @param string $command
     */
    public function __construct($command)
    {
        $this->command = $command;
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
            'command' => $this->command,
            'force' => $this->force
        ]);
    }

}