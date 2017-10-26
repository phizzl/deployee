<?php
/**
 * ${CARET}<File description>
 *
 * @author Phillip Schleicher <schleicher@nexus-netsoft.com>
 * @package
 * @subpackage
 * @category
 */

namespace Deployee\Kernel;

interface ModuleInterface
{
    /**
     * @param Locator $locator
     */
    public function setLocator(Locator $locator);

    /**
     * @param FactoryInterface $factory
     */
    public function setFactory(FactoryInterface $factory);

    /**
     * @param FacadeInterface $facade
     */
    public function setFacade(FacadeInterface $facade);

    /**
     * @return FactoryInterface
     */
    public function getFactory();

    /**
     * @return FacadeInterface
     */
    public function getFacade();
}