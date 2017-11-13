<?php


namespace Deployee\Plugins\i18n;


use Deployee\Dependency\DependencyProviderInterface;
use Deployee\Kernel\Locator;
use Symfony\Component\Finder\Finder;

class DependencyProvider implements DependencyProviderInterface
{
    /**
     * @param Locator $locator
     */
    public function defineDependencies(Locator $locator)
    {
        $locator->Dependency()->setDependency(Module::LANGUAGE_COLLECTION_DEPENDENCY, function() use ($locator){
            return [
                Module::LANG_US_EN,
                Module::LANG_DE_DE
            ];
        });

        $locator->Dependency()->setDependency(Module::TRANSLATION_COLLECTION_DEPENDENCY, function() use ($locator){
            /* @var array $languagesToLoad */
            $languagesToLoad = $locator->Dependency()->getDependency(Module::LANGUAGE_COLLECTION_DEPENDENCY);

            $searchableDiretories = [];
            foreach($locator->ClassLoader()->getFacade()->getPrefixesPsr4() as $prefixes){
                $searchableDiretories = array_merge($searchableDiretories, $prefixes);
            }

            $return = [];
            foreach($languagesToLoad as $lang){
                /* @var TranslationCollection $translation */
                $translation = $locator->i18n()->getFactory()->createTranslationCollection();
                $expectedFileName = "lang_{$lang}.ini";
                $finder = new Finder();
                $finder
                    ->files()
                    ->name($expectedFileName)
                    ->depth("<= 1")
                    ->in($searchableDiretories);

                foreach($finder as $item){
                    $translation->addFromFile($item->getRealPath());
                }

                $return[$lang] = $translation;
            }

            return $return;
        });
    }

}