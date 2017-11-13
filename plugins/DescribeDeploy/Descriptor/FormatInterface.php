<?php

namespace Deployee\Plugins\DescribeDeploy\Descriptor;

interface FormatInterface
{
    /**
     * @return string
     */
    public function newLine();

    /**
     * @param string $str
     * @return string
     */
    public function headline($str);

    /**
     * @param string $str
     * @return string
     */
    public function subHeadline($str);

    /**
     * @param string $str
     * @return mixed
     */
    public function write($str);

    /**
     * @param string $str
     * @return string
     */
    public function bold($str);

    /**
     * @param string $str
     * @return string
     */
    public function italic($str);

    /**
     * @param string $str
     * @return string
     */
    public function writeLine($str);
}