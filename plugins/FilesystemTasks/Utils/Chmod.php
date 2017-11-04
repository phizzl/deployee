<?php


namespace Deployee\Plugins\FilesystemTasks\Utils;

class Chmod
{
    /**
     * @param string $path
     * @param int $permissions
     * @param bool $recursive
     * @return bool
     */
    public function chmod($path, $permissions, $recursive = false)
    {
        if($recursive){
            $this->recursiveChmod($path, $permissions);
        }
        else{
            $this->setChmod($path, $permissions);
        }

        return true;
    }

    /**
     * @param string $path
     * @param int $permissions
     */
    private function recursiveChmod($path, $permissions)
    {
        $this->setChmod($path, $permissions);
        if(is_dir($path)){
            foreach(new \DirectoryIterator($path) as $item){
                if($item->isDot()){
                    continue;
                }

                $this->recursiveChmod($item->getRealPath(), $permissions);
            }
        }
    }

    /**
     * @param string $path
     * @param int $permissions
     */
    private function setChmod($path, $permissions)
    {
        if(chmod($path, $permissions) === false){
            throw new \RuntimeException("Could not set permissions to file \"{$path}\"");
        }
    }
}