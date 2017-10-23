<?php

namespace Deployee\Plugins\DeployOxid\Tasks;


use Deployee\Collection;
use Deployee\Tasks\TaskInterface;

class ShopLangKey implements TaskInterface
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
        $this->path = "application/translations/{$langAbbr}";
    }

    /**
     * @param string $path
     */
    public function saveTo($path)
    {
        $this->path = $path;
    }

    /**
     * @return Collection
     */
    public function getDefinition()
    {
        return new Collection([
            'langabbr' => $this->langAbbr,
            'key' => $this->key,
            'value' => $this->value,
            'path' => $this->path
        ]);
    }

}