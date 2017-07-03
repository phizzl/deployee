<?php

namespace Phizzl\Deployee\Tasks;

use Phizzl\Deployee\CollectionInterface;

interface TaskInterface
{
    /**
     * @return CollectionInterface
     */
    public function getDefinition();
}