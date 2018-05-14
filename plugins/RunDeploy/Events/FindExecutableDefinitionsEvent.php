<?php

namespace Deployee\Plugins\RunDeploy\Events;


use Deployee\Events\AbstractEvent;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class FindExecutableDefinitionsEvent extends AbstractEvent
{
    /**
     * @var array
     */
    private $definitions;

    /**
     * @var InputInterface
     */
    private $input;

    /**
     * @var OutputInterface
     */
    private $output;

    /**
     * FindExecutableDefinitionsEvent constructor.
     * @param array $definitions
     * @param InputInterface $input
     * @param OutputInterface $output
     */
    public function __construct(array $definitions, InputInterface $input, OutputInterface $output)
    {
        $this->definitions = $definitions;
        $this->input = $input;
        $this->output = $output;
    }

    /**
     * @return InputInterface
     */
    public function getInput()
    {
        return $this->input;
    }

    /**
     * @return array
     */
    public function getDefinitions()
    {
        return $this->definitions;
    }

    /**
     * @param array $definitions
     */
    public function setDefinitions(array $definitions)
    {
        $this->definitions = $definitions;
    }

    /**
     * @return OutputInterface
     */
    public function getOutput()
    {
        return $this->output;
    }
}