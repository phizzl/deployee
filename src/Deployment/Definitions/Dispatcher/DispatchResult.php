<?php

namespace Deployee\Deployment\Definitions\Dispatcher;


class DispatchResult implements DispatchResultInterface
{
    /**
     * @var int
     */
    private $exitCode;

    /**
     * @var string
     */
    private $stdOutput;

    /**
     * @var string
     */
    private $errOutput;

    /**
     * DispatchResult constructor.
     * @param int $exitCode
     * @param string $stdOutput
     * @param string $errOutput
     */
    public function __construct($exitCode, $stdOutput, $errOutput)
    {
        $this->exitCode = $exitCode;
        $this->stdOutput = $stdOutput;
        $this->errOutput = $errOutput;
    }

    /**
     * @return int
     */
    public function getExitCode()
    {
        return $this->exitCode;
    }

    /**
     * @return string
     */
    public function getOutput()
    {
        return $this->stdOutput;
    }

    /**
     * @return string
     */
    public function getErrorOutput()
    {
        return $this->errOutput;
    }
}