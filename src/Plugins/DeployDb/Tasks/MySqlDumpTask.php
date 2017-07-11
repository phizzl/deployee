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
     * @var string
     */
    private $arguments;

    /**
     * MySqlDumpTask constructor.
     * @param $target
     */
    public function __construct($target)
    {
        $this->target = $target;
        $this->arguments = "";
    }

    /**
     * @param string $arguments
     * @return $this
     */
    public function arguments($arguments)
    {
        $this->arguments = $arguments;
        return $this;
    }

    /**
     * @return Collection
     */
    public function getDefinition()
    {
        return new Collection([
            'target' => $this->target,
            'arguments' => $this->arguments
        ]);
    }

}