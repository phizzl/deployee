<?php


namespace Phizzl\Deployee\Dispatcher\Filesystem;


use Phizzl\Deployee\Collection;
use Phizzl\Deployee\Tasks\TaskInterface;

class CreateDirTask implements TaskInterface
{
    /**
     * @var string
     */
    private $path;

    /**
     * @var bool
     */
    private $recursive;

    /**
     * CreateDirTask constructor.
     * @param string $path
     * @param bool $recursive
     */
    public function __construct($path, $recursive = false)
    {
        $this->path = $path;
        $this->recursive = $recursive;
    }

    /**
     * @return Collection
     */
    public function getDefinition()
    {
        return new Collection([
            'path' => $this->path,
            'recursive' => $this->recursive
        ]);
    }
}