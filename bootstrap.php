<?php
/**
 * Bootstrap file for Deployee task runner
 */

use Phizzl\Deployee\Bootstrap\Bootstrap;
use Phizzl\Deployee\Container;

$findLoader = [
    __DIR__ . '/vendor',
    __DIR__ . '/../../'
];

$loaderFile = '';
foreach($findLoader as $find){
    if(is_file($find . '/autoload.php')){
        $loaderFile = $find . '/autoload.php';
        break;
    }
}

if($loaderFile === ''){
    throw new \Exception("Could not find autoloader file");
}

$loader = require $loaderFile;

$di = new Container();
$di['composer.classloader'] = $loader;
$bootstrap = new Bootstrap($di);

return $bootstrap->bootstrap();