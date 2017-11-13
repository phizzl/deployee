<?php

namespace Deployee\Plugins\i18n;


use Deployee\Kernel\Modules\AbstractFactory;

class Factory extends AbstractFactory
{
    /**
     * @return TranslationCollection
     */
    public function createTranslationCollection()
    {
        return new TranslationCollection();
    }
}