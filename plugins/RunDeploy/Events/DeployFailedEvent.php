<?php

namespace Deployee\Plugins\RunDeploy\Events;

use Deployee\Events\AbstractEvent;
use Deployee\Plugins\RunDeploy\Dispatcher\DispatchResultInterface;

class DeployFailedEvent extends AbstractEvent
{
    /**
     * @var DispatchResultInterface
     */
    private $result;

    /**
     * DeployFailedEvent constructor.
     * @param DispatchResultInterface $result
     */
    public function __construct(DispatchResultInterface $result)
    {
        $this->result = $result;
    }

    /**
     * @return DispatchResultInterface
     */
    public function getResult()
    {
        return $this->result;
    }
}