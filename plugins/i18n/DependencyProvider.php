<?php


namespace Deployee\Plugins\i18n;


use Deployee\Dependency\DependencyProviderInterface;
use Deployee\Kernel\Locator;

class DependencyProvider implements DependencyProviderInterface
{
    /**
     * @param Locator $locator
     */
    public function defineDependencies(Locator $locator)
    {
        $locator->Dependency()->setDependency(Module::TRANSLATION_COLLECTION_DEPENDENCY, function() use ($locator){
            return [
                Module::LANG_US_EN => $locator->i18n()->getFactory()->createTranslationCollection(),
                Module::LANG_DE_DE => $locator->i18n()->getFactory()->createTranslationCollection()
            ];
        });
    }

}