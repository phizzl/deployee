<?php

namespace Deployee\Plugins\Annotations;


use Deployee\Kernel\Modules\AbstractFacade;
use phpDocumentor\Reflection\DocBlock;

class Facade extends AbstractFacade
{
    /**
     * @var array
     */
    private $docBlocks;

    /**
     * Facade constructor.
     */
    public function __construct()
    {
        $this->docBlocks = [];
    }

    /**
     * @param object|string $class
     * @return DocBlock\Tag[]
     */
    public function getTags($class)
    {
        /* @var DocBlock $docBlock */
        $docBlock = $this->locator->Annotations()->getFacade()->getDocBlock($class);

        return $docBlock->getTags();
    }

    /**
     * @param object|string $class
     * @param string $tagName
     * @return bool
     */
    public function hasTag($class, $tagName)
    {
        /* @var DocBlock $docBlock */
        $docBlock = $this->locator->Annotations()->getFacade()->getDocBlock($class);

        return $docBlock->hasTag($tagName);
    }

    /**
     * @param object|string $class
     * @param string $tagName
     * @return DocBlock\Tag[]
     */
    public function getTagsByName($class, $tagName)
    {
        /* @var DocBlock $docBlock */
        $docBlock = $this->locator->Annotations()->getFacade()->getDocBlock($class);

        return $docBlock->getTagsByName($tagName);
    }

    /**
     * @param object|string $class
     * @return DocBlock
     */
    public function getDocBlock($class)
    {
        $hash = is_object($class) ? spl_object_hash($class) : sha1($class);
        if(!isset($this->docBlocks[$hash])){
            $this->docBlocks[$hash] = $this->locator->Annotations()->getFactory()->createInstanceDocBlock($class);
        }

        return $this->docBlocks[$hash];
    }
}