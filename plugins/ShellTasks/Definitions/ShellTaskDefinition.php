<?php

namespace Deployee\Plugins\ShellTasks\Definitions;


use Deployee\Deployment\Definitions\Parameter\ParameterCollection;
use Deployee\Deployment\Definitions\Tasks\AbstractTaskDefinition;

class ShellTaskDefinition extends AbstractTaskDefinition
{
    /**
     * @var ParameterCollection
     */
    private $parameter;

    /**
     * DirectoryTask constructor.
     * @param string $executable
     */
    public function __construct($executable)
    {
        $this->parameter = new ParameterCollection([
            'executable' => $executable
        ]);
    }

    /**
     * @param string $arguments
     * @return $this
     */
    public function arguments($arguments)
    {
        $this->parameter->set('arguments', $arguments);
        return $this;
    }

    /**
     * @return ParameterCollection
     */
    public function define()
    {
        return $this->parameter;
    }
}