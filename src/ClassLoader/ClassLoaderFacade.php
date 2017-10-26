<?php


namespace Deployee\ClassLoader;


use Deployee\Kernel\Modules\AbstractFacade;

class ClassLoaderFacade extends AbstractFacade
{
    /**
     * @var ClassLoaderFactory
     */
    protected $factory;

    /**
     * @return array
     */
    public function getPrefixesPsr4()
    {
        return $this->factory->createClassLoader()->getPrefixesPsr4();
    }

    /**
     * @return array
     */
    public function getRegisteredNamespaces()
    {
        return array_keys($this->getPrefixesPsr4());
    }

    /**
     * @param array $classMap
     */
    public function addClassMap(array $classMap)
    {
        $this->factory->createClassLoader()->addClassMap($classMap);
    }
}