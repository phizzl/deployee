<?php

namespace Phizzl\Deployee;


interface ContainerAwareInterface
{
    /**
     * @param Container $container
     */
    public function setContainer(Container $container);
}