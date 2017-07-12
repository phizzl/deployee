<?php


namespace Deployee\Plugins\DeployFilesystem\Tasks;


use Deployee\Collection;
use Deployee\Tasks\TaskInterface;

class PermissionsTask implements TaskInterface
{
    /**
     * @var string
     */
    private $path;

    /**
     * @var int
     */
    private $permissions;

    /**
     * @var string
     */
    private $owner;

    /**
     * @var string
     */
    private $group;

    /**
     * @var bool
     */
    private $recursive;

    /**
     * DirectoryTask constructor.
     * @param string $path
     */
    public function __construct($path)
    {
        $this->path = $path;
        $this->owner = '';
        $this->group = '';
        $this->permissions = 0777;
        $this->recursive = false;
    }

    /**
     * @param int $permissions
     * @return $this
     */
    public function permissions($permissions)
    {
        $this->permissions = $permissions;
        return $this;
    }

    /**
     * @param string $owner
     * @return $this
     */
    public function owner($owner)
    {
        $this->owner = $owner;
        return $this;
    }

    /**
     * @param string $group
     * @return $this
     */
    public function group($group)
    {
        $this->group = $group;
        return $this;
    }

    /**
     * @param bool $recursive
     * @return $this
     */
    public function recursive()
    {
        $this->recursive = true;
        return $this;
    }

    /**
     * @return Collection
     */
    public function getDefinition()
    {
        return new Collection([
            'path' => $this->path,
            'owner' => $this->owner,
            'group' => $this->group,
            'permissions' => $this->permissions,
            'recursive' => $this->recursive
        ]);
    }
}