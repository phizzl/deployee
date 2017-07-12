<?php

namespace Deployee\Tasks;

use Deployee\CollectionInterface;

interface TaskInterface
{
    /**
     * @return CollectionInterface
     */
    public function getDefinition();
}