<?php

namespace Deployee\Bootstrap;


class BootstrapArguments
{
    const CONATINER_ID = "deployee.bootstrap.arguments";

    /**
     * @var array
     */
    private $args;

    /**
     * @var array
     */
    private $parsed;

    /**
     * BootstrapArguments constructor.
     * @param array $args
     */
    public function __construct(array $args)
    {
        $this->args = $args;
    }

    /**
     * @param string $name
     * @return mixed
     */
    public function getOption($name)
    {
        $parsed = $this->parse();
        return isset($parsed[$name]) ? $parsed[$name] : null;
    }

    /**
     * @return array
     */
    private function parse()
    {
        if($this->parsed !== null){
            return $this->parsed;
        }

        unset($this->args[0]);
        $this->parsed = [];

        foreach($this->args as $arg){
            if(substr($arg, 0, 2) !== "--"){
                continue;
            }

            $parts = explode("=", substr($arg, 2));
            $this->parsed[$parts[0]] = isset($parts[1]) ? $parts[1] : '';
        }

        return $this->parsed;
    }
}