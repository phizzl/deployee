<?php


namespace Phizzl\Deployee\Dispatcher\Filesystem;


class RecursiveDirectoryRemover
{
    /**
     * @param string $path
     * @return bool
     */
    public function remove($path)
    {
        if(!is_dir($path)){
            throw new \InvalidArgumentException("Directory does not exist \"$path\"");
        }

        $this->removeItem($path);

        if(rmdir($path) === false){
            throw new \RuntimeException("Could not remove directory \"{$path}\"");
        }

        return true;
    }

    /**
     * @param string $path
     */
    private function removeItem($path)
    {
        foreach(new \DirectoryIterator($path) as $item){
            if($item->isDot()){
                continue;
            }

            if($item->isFile()
                && unlink($item->getRealPath()) === false){
                throw new \RuntimeException("Could not remove file \"{$item->getRealPath()}\"");
            }

            if($item->isDir()){
                $this->removeItem($item->getRealPath());
                if(rmdir($item->getRealPath()) === false){
                    throw new \RuntimeException("Could not remove directory \"{$item->getRealPath()}\"");
                }
            }
        }
    }
}