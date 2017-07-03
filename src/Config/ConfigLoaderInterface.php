<?php

namespace Phizzl\Deployee\Config;


interface ConfigLoaderInterface
{
    const CONTAINER_ID = "deployee.config.loader";

    /**
     * @return array|\ArrayAccess
     */
    public function load();
}