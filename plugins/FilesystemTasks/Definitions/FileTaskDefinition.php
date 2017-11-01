<?php

namespace Deployee\Plugins\FilesystemTasks\Definitions;


use Deployee\Deployment\Definitions\Parameter\ParameterCollection;
use Deployee\Deployment\Definitions\Tasks\AbstractTaskDefinition;

class FileTaskDefinition extends AbstractTaskDefinition
{
    /**
     * @var ParameterCollection
     */
    private $parameter;

    /**
     * DirectoryTask constructor.
     * @param string $path
     */
    public function __construct($path)
    {
        $this->parameter = new ParameterCollection([
            'path' => $path
        ]);
    }

    /**
     * @param string $contents
     * @return $this
     */
    public function contents($contents)
    {
        $this->parameter->set('contents', $contents);
        $this->parameter->set('remove', false);
        $this->parameter->set('copy', null);
        $this->parameter->set('symlink', null);
        return $this;
    }

    /**
     * @return $this
     */
    public function remove()
    {
        $this->parameter->set('remove', true);
        $this->parameter->set('contents', null);
        $this->parameter->set('copy', null);
        $this->parameter->set('symlink', null);
        return $this;
    }

    /**
     * @param string $source
     * @return $this
     */
    public function copy($source)
    {
        $this->parameter->set('copy', $source);
        $this->parameter->set('contents', null);
        $this->parameter->set('remove', null);
        $this->parameter->set('symlink', null);
        return $this;
    }

    public function symlink($symlinkTarget)
    {
        $this->parameter->set('symlink', $symlinkTarget);
        $this->parameter->set('copy', null);
        $this->parameter->set('contents', null);
        $this->parameter->set('remove', null);
        return $this;
    }

    /**
     * @return ParameterCollection
     */
    public function define()
    {
        return $this->parameter;
    }
}