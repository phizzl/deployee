<?php


namespace Deployee\Plugins\ShellTasks\Services;


use Phizzl\PhpShellCommand\ShellCommand;

class ExecutableFinderService
{
    /**
     * @var array
     */
    private $aliase;

    /**
     * ExecutableFinderService constructor.
     * @param array $alias
     */
    public function __construct( array $aliase = [])
    {
        $this->aliase = $aliase;
    }

    /**
     * @param string $name
     * @return string
     */
    public function find($name)
    {
        $return = $name;
        if(isset($this->aliase[$name])){
            $return = $this->aliase[$name];
        }
        elseif(trim($name) != ""
            && $path = $this->which($name)){
            $return = $path;
        }

        return $return;
    }

    /**
     * Usage:
     * ExecutableFinderService::addAlias('mysqldump', '/usr/local/mysql5/bin/mysqldump')
     *
     * @param string $alias
     * @param string $resolved
     */
    public function addAlias($alias, $resolved)
    {
        $this->aliase[$alias] = $resolved;
    }

    /**
     * @param string $name
     * @return string
     */
    private function which($name)
    {
        $isOsWin = strtoupper(substr(PHP_OS, 0, 3)) === 'WIN';

        $which = $isOsWin ? "where" : "which";

        $cmd = new ShellCommand($which, $name);
        $result = $cmd->run();

        return $result->getExitCode() > 0 ? '' : trim($result->getOutput());
    }
}