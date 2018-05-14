<?php

namespace Deployee\Plugins\ShopwareTasks\Definitions;


use Deployee\Deployment\Definitions\Parameter\ParameterCollection;
use Deployee\Deployment\Definitions\Parameter\ParameterCollectionInterface;
use Deployee\Deployment\Definitions\Tasks\AbstractTaskDefinition;

class ShopwareCommandDefinition extends AbstractTaskDefinition
{
    /**
     * @var string
     */
    private $command;

    /**
     * @var string
     */
    private $arguments;

    /**
     * ShopwareCommandDefinition constructor.
     * @param string $command
     * @param string $arguments
     */
    public function __construct($command, $arguments = '')
    {
        $this->command = $command;
        $this->arguments = $arguments;
    }

    /**
     * @return ParameterCollection
     */
    public function define()
    {
        return new ParameterCollection(get_object_vars($this));
    }
}