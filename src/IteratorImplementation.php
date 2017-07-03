<?php

namespace Phizzl\Deployee;


trait IteratorImplementation
{
    use ArrayAccessImplementation;

    /**
     * @return mixed
     */
    public function current()
    {
        return current($this->array);
    }

    /**
     * @return mixed
     */
    public function next()
    {
        return next($this->array);
    }

    /**
     * @return mixed
     */
    public function key()
    {
        return key($this->array);
    }

    /**
     * @return bool
     */
    public function valid()
    {
        return $this->current() !== false;
    }

    /**
     * @return void
     */
    public function rewind()
    {
        reset($this->array);
    }
}