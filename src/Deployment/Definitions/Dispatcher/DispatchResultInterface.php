<?php

namespace Deployee\Deployment\Definitions\Dispatcher;

interface DispatchResultInterface
{
    /**
     * @return int
     */
    public function getExitCode();

    /**
     * @return string
     */
    public function getOutput();

    /**
     * @return string
     */
    public function getErrorOutput();
}