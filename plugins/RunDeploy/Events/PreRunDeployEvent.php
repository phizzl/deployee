<?php

namespace Deployee\Plugins\RunDeploy\Events;

use Deployee\Events\AbstractEvent;
use Symfony\Component\Console\Input\InputInterface;

class PreRunDeployEvent extends AbstractEvent
{
    /**
     * @var InputInterface
     */
    private $input;

    /**
     * PreRunDeployEvent constructor.
     * @param InputInterface $input
     */
    public function __construct(InputInterface $input)
    {
        $this->input = $input;
    }

    /**
     * @return InputInterface
     */
    public function getInput()
    {
        return $this->input;
    }
}