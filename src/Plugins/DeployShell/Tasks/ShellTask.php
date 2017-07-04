<?php


namespace Phizzl\Deployee\Plugins\DeployShell\Tasks;

use Phizzl\Deployee\Collection;
use Phizzl\Deployee\Tasks\TaskInterface;

class ShellTask implements TaskInterface
{
    /**
     * @var string
     */
    private $executable;

    /**
     * @var string
     */
    private $arguments;

    /**
     * ShellTask constructor.
     * @param string $executable
     */
    public function __construct($executable)
    {
        $this->executable = $executable;
        $this->arguments = '';
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
            'executable' => $this->executable,
            'arguments' => $this->arguments
        ]);
    }
}