<?php

namespace Deployee\Plugins\FilesystemTasks\Definitions;


use Deployee\Deployment\Definitions\Parameter\ParameterCollection;
use Deployee\Deployment\Definitions\Tasks\AbstractTaskDefinition;

class PermissionsTaskDefinition extends AbstractTaskDefinition
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
     * @param int $permissions
     * @return $this
     */
    public function permissions($permissions)
    {
        $this->parameter->set('permissions', $permissions);
        return $this;
    }

    /**
     * @param string $owner
     * @return $this
     */
    public function owner($owner)
    {
        $this->parameter->set('owner', $owner);
        return $this;
    }

    /**
     * @param string $group
     * @return $this
     */
    public function group($group)
    {
        $this->parameter->set('group', $group);
        return $this;
    }

    /**
     * @param bool $recursive
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