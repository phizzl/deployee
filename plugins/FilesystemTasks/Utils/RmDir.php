<?php


namespace Deployee\Plugins\FilesystemTasks\Utils;


class RmDir
{
    /**
     * @var Rm
     */
    private $rm;

    /**
     * RmDir constructor.
     */
    public function __construct()
    {
        $this->rm = new Rm();
    }

    /**
     * @param string $path
     * @return bool
     */
    public function remove($path, $recursive = false)
    {
        if(!is_dir($path)){
            throw new \InvalidArgumentException("Directory does not exist \"$path\"");
        }

        if($recursive === true){
            $this->removeRecursive($path);
        }
        else{
            $this->rm->remove($path);
        }

        return true;
    }

    /**
     * @param string $path
     */
    private function removeRecursive($path)
    {
        foreach(new \DirectoryIterator($path) as $item){
            if($item->isDot()){
                continue;
            }

            if($item->isDir()){
                $this->removeRecursive($item->getRealPath());
            }
            else{
                $this->rm->remove($item->getRealPath());
            }
        }

        $this->rm->remove($path);
    }
}