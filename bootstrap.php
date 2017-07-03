<?php
/**
 * Bootstrap file for Deployee task runner
 */

use Phizzl\Deployee\Bootstrap\Bootstrap;
use Phizzl\Deployee\Container;

$loader = require __DIR__ . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php';

$di = new Container();
$di['composer.classloader'] = $loader;
$bootstrap = new Bootstrap($di);

return $bootstrap->bootstrap();