<?php

namespace Deployee\Kernel\Modules;


class ModuleCollection
{
    /**
     * @var array
     */
    private $modules;

    /**
     * ModuleCollection constructor.
     */
    public function __construct()
    {
        $this->modules = [];
    }

    /**
     * @param string $name
     * @param ModuleInterface $module
     */
    public function addModule($name, ModuleInterface $module)
    {
        $this->modules[$name] = $module;
    }

    /**
     * @param string $name
     * @return bool
     */
    public function hasModule($name)
    {
        return isset($this->modules[$name]);
    }

    /**
     * @param string $name
     * @return ModuleInterface
     */
    public function getModule($name)
    {
        if(!$this->hasModule($name)){
            throw new \InvalidArgumentException("Module dies not exist: \"{$name}\"");
        }

        return $this->modules[$name];
    }
}