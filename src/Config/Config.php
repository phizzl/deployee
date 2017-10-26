<?php

namespace Deployee\Config;


class Config
{
    /**
     * @var array|\ArrayAccess
     */
    private $params;

    /**
     * @param array|\ArrayAccess $params
     */
    public function setParams($params)
    {
        if(!is_array($params)
            && !$params instanceof \ArrayAccess){
            throw new \InvalidArgumentException("Params must be array or implement \\ArrayAcess interface");
        }

        $this->params = $params;
    }

    /**
     * @param string $name
     * @param mixed $default
     * @return mixed
     */
    public function get($name, $default = null)
    {
        return isset($this->params[$name]) ? $this->params[$name] : $default;
    }
}