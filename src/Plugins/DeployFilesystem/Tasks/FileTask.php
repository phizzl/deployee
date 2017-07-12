<?php


namespace Deployee\Plugins\DeployFilesystem\Tasks;


use Deployee\Collection;
use Deployee\Tasks\TaskInterface;

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
     * @var string
     */
    private $copy;

    /**
     * DirectoryTask constructor.
     * @param string $path
     */
    public function __construct($path)
    {
        $this->path = $path;
        $this->contents = '';
        $this->remove = false;
        $this->copy = '';
    }

    /**
     * @param string $contents
     * @return $this
     */
    public function contents($contents)
    {
        $this->contents = $contents;
        $this->remove = false;
        $this->copy = '';
        return $this;
    }

    /**
     * @return $this
     */
    public function remove()
    {
        $this->remove = true;
        $this->contents = '';
        $this->copy = '';
        return $this;
    }

    /**
     * @param string $source
     * @return $this
     */
    public function copy($source)
    {
        $this->copy = $source;
        $this->contents = '';
        $this->remove = false;
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