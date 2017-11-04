<?php

namespace Deployee\Plugins\RunDeploy\Events;

use Deployee\Events\AbstractEvent;

class PostRunDeploy extends AbstractEvent
{
    /**
     * @var bool
     */
    private $success;

    /**
     * PostRunDeploy constructor.
     * @param bool $success
     */
    public function __construct($success)
    {
        $this->success = $success;
    }

    /**
     * @return bool
     */
    public function isSuccess()
    {
        return $this->success;
    }
}