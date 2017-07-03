<?php

namespace Phizzl\Deployee\Tasks;

interface TaskInterface
{
    /**
     * @return TaskResultInterface
     */
    public function run();
}