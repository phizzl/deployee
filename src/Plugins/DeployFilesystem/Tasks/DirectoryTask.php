<?php


namespace Phizzl\Deployee\Plugins\DeployFilesystem\Tasks;


use Phizzl\Deployee\Collection;
use Phizzl\Deployee\Tasks\TaskInterface;

class DirectoryTask implements TaskInterface
{
    /**
     * @var string
     */
    private $path;

    /**
     * @var bool
     */
    private $create;

    /**
     * @var bool
     */
    private $remove;

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
        $this->create = true;
        $this->remove = false;
        $this->recursive = false;
    }


    /**
     * @return $this
     */
    public function create()
    {
        $this->create = true;
        $this->remove = false;
        return $this;
    }

    /**
     * @return $this
     */
    public function remove()
    {
        $this->remove = true;
        $this->create = false;
        return $this;
    }

    /**
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
            'recursive' => $this->recursive,
            'create' => $this->create,
            'remove' => $this->remove
        ]);
    }
}