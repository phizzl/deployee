<?php

namespace Deployee\Plugins\MySqlTasks\Definitions;

use Deployee\Deployment\Definitions\Parameter\ParameterCollection;
use Deployee\Deployment\Definitions\Tasks\AbstractTaskDefinition;

class MySqlFileDefinition extends AbstractTaskDefinition
{
    /**
     * @var string
     */
    private $source;

    /**
     * @var bool
     */
    private $force;

    /**
     * MySqlDumpTask constructor.
     * @param $target
     */
    public function __construct($source)
    {
        $this->source = $source;
        $this->force = false;
    }

    /**
     * @return $this
     */
    public function force()
    {
        $this->force = true;
        return $this;
    }

    /**
     * @return ParameterCollection
     */
    public function define()
    {
        return new ParameterCollection([
            'source' => $this->source,
            'force' => $this->force
        ]);
    }
}