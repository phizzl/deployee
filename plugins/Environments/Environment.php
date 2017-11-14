<?php

namespace Deployee\Plugins\Environments;


class Environment
{
    /**
     * @var string
     */
    private $name;

    /**
     * Environment constructor.
     * @param string $name
     */
    public function __construct($name)
    {
        $this->name = $name;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }
}