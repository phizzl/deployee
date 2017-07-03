<?php


namespace Phizzl\Deployee\Dispatcher\Filesystem;


use Phizzl\Deployee\Collection;
use Phizzl\Deployee\Tasks\TaskInterface;

class FileTask implements TaskInterface
{
    /**
     * @var string
     */
    private $path;

    /**
     * @var int
     */
    private $contents;

    /**
     * @var bool
     */
    private $remove;

    /**
     * DirectoryTask constructor.
     * @param string $path
     */
    public function __construct($path)
    {
        $this->path = $path;
        $this->contents = '';
        $this->remove = false;
    }

    /**
     * @param string $contents
     * @return $this
     */
    public function contents($contents)
    {
        $this->contents = $contents;
        $this->remove = false;
        return $this;
    }

    /**
     * @return $this
     */
    public function remove()
    {
        $this->remove = true;
        $this->contents = '';
        return $this;
    }

    /**
     * @return Collection
     */
    public function getDefinition()
    {
        return new Collection([
            'path' => $this->path,
            'contents' => $this->contents,
            'remove' => $this->remove
        ]);
    }
}