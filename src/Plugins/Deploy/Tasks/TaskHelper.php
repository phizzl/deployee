<?php

namespace Deployee\Plugins\Deploy\Tasks;


use Deployee\Collection;
use Deployee\Tasks\TaskInterface;

class TaskHelper
{
    const CONTAINER_ID = "deployee.plugin.deploy.taskhelper";

    /**
     * @var Collection
     */
    private $collection;

    /**
     * TaskHelper constructor.
     */
    public function __construct()
    {
        $this->collection = new Collection();
    }

    /**
     * @param string $taskClass
     * @param string $methodName
     */
    public function registerTask($taskClass, $methodName)
    {
        if(isset($this->collection[$methodName])){
            throw new \LogicException("\"$methodName\" is already defined");
        }

        $this->collection[$methodName] = $taskClass;
    }

    /**
     * @param string $name
     * @param array $arguments
     * @return TaskInterface
     */
    public function __call($name, $arguments)
    {
        if(!isset($this->collection[$name])){
            throw new \BadMethodCallException("Method \"$name\" does not exist");
        }

        $taskClass = $this->collection[$name];

        if(!($object = new $taskClass(...$arguments)) instanceof TaskInterface){
            throw new \RuntimeException("Helper must return TaskInterface");
        }

        return $object;
    }
}