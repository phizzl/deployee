<?php

namespace Deployee\Plugins;


use Deployee\ArrayAccessImplementation;

class PluginContainer implements \ArrayAccess
{
    const CONTAINER_ID = "plugins.container";

    use ArrayAccessImplementation;
}