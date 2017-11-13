<?php

namespace Deployee\Plugins\i18n;


use Deployee\Kernel\Modules\AbstractFacade;

class Facade extends AbstractFacade
{
    /**
     * @param string $lang
     * @return TranslationCollection
     */
    private function getTranslations($lang)
    {
        $translations = $this->locator->Dependency()->getFacade()->getDependency(Module::TRANSLATION_COLLECTION_DEPENDENCY);
        if(!isset($translations[$lang])){
            $lang = Module::LANG_US_EN;
        }

        return $translations[$lang];
    }

    /**
     * @param string $lang
     * @param string $ident
     * @param array $params
     * @return mixed
     */
    public function translate($lang, $ident, array $params = [])
    {
        $str = $this->getTranslations($lang)->get($ident);
        $replace = [];
        foreach($params as $name => $value){
            $replace["%{$name}%"] = $value;
        }

        return str_replace(array_keys($replace), $replace, $str);
    }

}