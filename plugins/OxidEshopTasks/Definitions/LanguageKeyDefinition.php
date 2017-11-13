<?php

namespace Deployee\Plugins\OxidEshopTasks\Definitions;


use Deployee\Deployment\Definitions\Parameter\ParameterCollection;
use Deployee\Deployment\Definitions\Tasks\AbstractTaskDefinition;

class LanguageKeyDefinition extends AbstractTaskDefinition
{
    /**
     * @var string
     */
    private $langAbbr;

    /**
     * @var string
     */
    private $key;

    /**
     * @var string
     */
    private $value;

    /**
     * @var string
     */
    private $path;

    /**
     * ShopLangKey constructor.
     * @param string $langAbbr
     * @param string $key
     * @param string $value
     */
    public function __construct($langAbbr, $key, $value)
    {
        $this->langAbbr = $langAbbr;
        $this->key = $key;
        $this->value = $value;
        $this->path = "application/translations/{$langAbbr}/deployee_{$langAbbr}_lang.php";
    }

    /**
     * @param string $path
     */
    public function saveTo($path)
    {
        $this->path = $path;
        return $this;
    }

    /**
     * @return ParameterCollection
     */
    public function define()
    {
        return new ParameterCollection([
            'langabbr' => $this->langAbbr,
            'key' => $this->key,
            'value' => $this->value,
            'path' => $this->path
        ]);
    }
}