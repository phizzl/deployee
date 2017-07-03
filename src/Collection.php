<?php

namespace Phizzl\Deployee;


class Collection implements CollectionInterface
{
    use IteratorImplementation;

    /**
     * Collection constructor.
     * @param array $array
     */
    public function __construct(array $array = [])
    {
        $this->array = $array;
    }

    /**
     * @return int
     */
    public function count()
    {
        return count($this->array);
    }


}