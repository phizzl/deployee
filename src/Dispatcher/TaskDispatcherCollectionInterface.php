<?php

namespace Phizzl\Deployee\Dispatcher;


use Phizzl\Deployee\CollectionInterface;

interface TaskDispatcherCollectionInterface extends CollectionInterface
{
    /**
     * @param TaskDispatcherInterface $dispatcher
     */
    public function registerDispatcher(TaskDispatcherInterface $dispatcher);
}