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
     * @param object $object
     * @return DocBlock\Tag[]
     */
    public function getTags($object)
    {
        /* @var DocBlock $docBlock */
        $docBlock = $this->locator->Annotations()->getFacade()->getDocBlock($object);

        return $docBlock->getTags();
    }

    /**
     * @param object $object
     * @param string $tagName
     * @return bool
     */
    public function hasTag($object, $tagName)
    {
        /* @var DocBlock $docBlock */
        $docBlock = $this->locator->Annotations()->getFacade()->getDocBlock($object);

        return $docBlock->hasTag($tagName);
    }

    /**
     * @param object $object
     * @param string $tagName
     * @return DocBlock\Tag[]
     */
    public function getTagsByName($object, $tagName)
    {
        /* @var DocBlock $docBlock */
        $docBlock = $this->locator->Annotations()->getFacade()->getDocBlock($object);

        return $docBlock->getTagsByName($tagName);
    }

    /**
     * @param object $object
     * @return DocBlock
     */
    public function getDocBlock($object)
    {
        $hash = spl_object_hash($object);
        if(!isset($this->docBlocks[$hash])){
            $this->docBlocks[$hash] = $this->locator->Annotations()->getFactory()->createInstanceDocBlock($object);
        }

        return $this->docBlocks[$hash];
    }
}