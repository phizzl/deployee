<?php

namespace Deployee\Plugins\FilesystemTasks\Definitions;


use Deployee\Deployment\Definitions\Parameter\ParameterCollection;
use Deployee\Deployment\Definitions\Tasks\AbstractTaskDefinition;

class DirectoryTaskDefinition extends AbstractTaskDefinition
{
    /**
     * @var ParameterCollection
     */
    private $parameter;

    /**
     * DirectoryTask constructor.
     * @param string $path
     */
    public function __construct($path)
    {
        $this->parameter = new ParameterCollection([
            'path' => $path
        ]);
    }


    /**
     * @return $this
     */
    public function create()
    {
        $this->parameter->set('create', true);
        $this->parameter->set('remove', false);
        return $this;
    }

    /**
     * @return $this
     */
    public function remove()
    {
        $this->parameter->set('remove', true);
        $this->parameter->set('create', false);
        return $this;
    }

    /**
     * @return $this
     */
    public function recursive()
    {
        $this->parameter->set('recursive', true);
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