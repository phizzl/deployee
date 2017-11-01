<?php

namespace Deployee\Deployment\Definitions\Parameter;


class ParameterCollection implements ParameterCollectionInterface
{
    /**
     * @var array
     */
    private $values;

    /**
     * ParameterCollection constructor.
     * @param array $values
     */
    public function __construct(array $values = [])
    {
        $this->values = $values;
    }

    /**
     * @param string $id
     * @param mixed $value
     */
    public function set($id, $value)
    {
        $this->values[$id] = $value;
    }

    /**
     * @param string $id
     * @return mixed
     */
    public function get($id)
    {
        return isset($this->values[$id]) ? $this->values[$id] : null;
    }
}