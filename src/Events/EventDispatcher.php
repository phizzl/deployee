<?php

namespace Deployee\Events;


class EventDispatcher extends \Symfony\Component\EventDispatcher\EventDispatcher
{
    const CONTAINER_ID = "deployee.events.dispatcher";
}