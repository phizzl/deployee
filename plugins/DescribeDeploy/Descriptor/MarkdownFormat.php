<?php

namespace Deployee\Plugins\DescribeDeploy\Descriptor;


class MarkdownFormat implements FormatInterface
{
    /**
     * @return string
     */
    private function endLine()
    {
        return "\n";
    }

    /**
     * @return string
     */
    public function newLine()
    {
        return "  " . $this->endLine();
    }

    /**
     * @param string $str
     * @return string
     */
    public function headline($str)
    {
        return "# {$str}" . $this->endLine() . $this->endLine();
    }

    /**
     * @param string $str
     * @return string
     */
    public function subHeadline($str)
    {
        return "## {$str}" . $this->endLine() . $this->endLine();
    }

    /**
     * @param string $str
     * @return mixed
     */
    public function write($str)
    {
        return $str;
    }

    /**
     * @param string $str
     * @return string
     */
    public function bold($str)
    {
        return "**{$str}**";
    }

    /**
     * @param string $str
     * @return string
     */
    public function italic($str)
    {
        return "_{$str}_";
    }

    /**
     * @param string $str
     * @return string
     */
    public function writeLine($str)
    {
        return $this->write($str) . $this->newLine();
    }
}