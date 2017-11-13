<?php

namespace Deployee\Plugins\DescribeDeploy\Descriptor;

class Descriptor
{
    /**
     * @var FormatInterface
     */
    private $format;

    /**
     * @var array
     */
    private $contents;

    /**
     * Descriptor constructor.
     * @param FormatInterface $format
     */
    public function __construct(FormatInterface $format)
    {
        $this->format = $format;
        $this->contents = [];
    }

    /**
     * @param string $str
     */
    public function addDefinitionTitle($str)
    {
        $this->contents[] = $this->format->headline($str);
    }

    /**
     * @return string
     */
    public function printContents()
    {
        return implode("", $this->contents);
    }
}