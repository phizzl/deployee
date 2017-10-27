<?php

namespace Deployee\Deployment\Definitions\Parameter;


interface ParameterCollectionInterface
{
    /**
     * @param string $id
     * @param mixed $value
     * @return mixed
     */
    public function set($id, $value);

    /**
     * @param string $id
     * @return mixed
     */
    public function get($id);
}