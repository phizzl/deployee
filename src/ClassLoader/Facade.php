<?php


namespace Deployee\ClassLoader;


use Deployee\Kernel\Modules\AbstractFacade;

class Facade extends AbstractFacade
{
    /**
     * @return array
     */
    public function getPrefixesPsr4()
    {
        return $this->locator->ClassLoader()->getFactory()->createClassLoader()->getPrefixesPsr4();
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
        $this->locator->ClassLoader()->getFactory()->createClassLoader()->addClassMap($classMap);
    }
}