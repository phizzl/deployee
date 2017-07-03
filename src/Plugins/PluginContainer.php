<?php

namespace Phizzl\Deployee\Plugins;


use Phizzl\Deployee\ArrayAccessImplementation;

class PluginContainer implements \ArrayAccess
{
    const CONTAINER_ID = "plugins.container";

    use ArrayAccessImplementation;
}