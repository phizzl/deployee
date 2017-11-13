<?php

namespace Deployee\Plugins\i18n;


class TranslationCollection
{
    /**
     * @var array
     */
    private $translations;

    /**
     * TranslationCollection constructor.
     */
    public function __construct()
    {
        $this->translations = [];
    }

    /**
     * @param string $ident
     * @param string $str
     */
    public function add($ident, $str)
    {
        $this->translations[$ident] = $str;
    }

    /**
     * @param string $filepath
     */
    public function addFromFile($filepath)
    {
        if(!($handle = fopen($filepath, 'r'))){
            throw new \RuntimeException("Could not open file {$filepath}");
        }

        while($line = fgets($handle)){
            $separator = strpos($line, '=');
            $ident = trim(substr($line, 0, $separator));
            $str = trim(substr($line, $separator +1));
            $this->add($ident, $str);
        }

        fclose($handle);
    }

    /**
     * @param string $ident
     * @return string
     */
    public function get($ident)
    {
        return isset($this->translations[$ident]) ? $this->translations[$ident] : $ident;
    }
}