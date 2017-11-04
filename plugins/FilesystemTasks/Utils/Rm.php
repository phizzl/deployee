<?php


namespace Deployee\Plugins\FilesystemTasks\Utils;


class Rm
{
    /**
     * @param string $path
     * @return bool
     */
    public function remove($path)
    {
        if(is_file($path)
            && unlink($path) === false){
            throw new \RuntimeException("Could not remove file \"{$path}\"");
        }

        if(is_dir($path)
            && rmdir($path) === false){
            throw new \RuntimeException("Could not remove directory \"{$path}\"");
        }

        return true;
    }
}