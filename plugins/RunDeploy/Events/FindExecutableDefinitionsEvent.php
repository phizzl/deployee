<?php

namespace Deployee\Plugins\RunDeploy\Events;


use Deployee\Events\AbstractEvent;

class FindExecutableDefinitionsEvent extends AbstractEvent
{
    /**
     * @var array
     */
    private $definitions;

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