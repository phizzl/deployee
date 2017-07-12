<?php

namespace Deployee;


interface ContainerAwareInterface
{
    /**
     * @param Container $container
     */
    public function setContainer(Container $container);
}