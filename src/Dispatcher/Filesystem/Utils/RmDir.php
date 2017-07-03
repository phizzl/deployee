<?php


namespace Phizzl\Deployee\Dispatcher\Filesystem\Utils;


class RmDir
{
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
            $this->removeFile($path);
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
                $this->removeFile($item->getRealPath());
            }
        }

        $this->removeFile($path);
    }

    /**
     * @param string $path
     */
    private function removeFile($path)
    {
        if(is_file($path)
            && unlink($path) === false){
            throw new \RuntimeException("Could not remove file \"{$path}\"");
        }

        if(is_dir($path)
            && rmdir($path) === false){
            throw new \RuntimeException("Could not remove directory \"{$path}\"");
        }
    }
}