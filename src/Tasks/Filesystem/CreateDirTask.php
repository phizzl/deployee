<?php

namespace Phizzl\Deployee\Tasks\Filesystem;


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

    public function run()
    {
        if(mkdir($this->path, 0777, $this->recursive)){

        }
    }


}