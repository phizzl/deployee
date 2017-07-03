#!/usr/bin/php
<?php

use Phizzl\Deployee\Application\Application;
use Phizzl\Deployee\Container;
use Phizzl\Deployee\Events\ApplicationInitializedEvent;


/* @var Container $container */
$container = require __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'bootstrap.php';

// Ensure plugin container was build
$container->plugins();

$application = new Application("Deployee", "2.0.0");
$application->setContainer($container);

$container->events()->dispatch(
    ApplicationInitializedEvent::EVENT_NAME,
    new ApplicationInitializedEvent($container, $application)
);

$application->run();