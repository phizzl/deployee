<?php

namespace Deployee\Plugins\RunDeploy\Events;


use Deployee\Events\AbstractEvent;
use Symfony\Component\Console\Input\InputInterface;

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
     * FindExecutableDefinitionsEvent constructor.
     * @param array $definitions
     * @param InputInterface $input
     */
    public function __construct(array $definitions, InputInterface $input)
    {
        $this->definitions = $definitions;
        $this->input = $input;
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
}