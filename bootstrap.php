<?php
/**
 * Bootstrap file for Deployee task runner
 */

use Composer\Autoload\ClassLoader;
use Deployee\Kernel\DependencyProvider;
use Deployee\Kernel\KernelConstraints;
use Deployee\Kernel\Locator;

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

/* @var ClassLoader $loader */
$loader = require $loaderFile;
$namespaces = array_merge(
    array_reverse(array_keys($loader->getPrefixesPsr4())),
    [
        "Deployee\\Components\\",
        "\\"
    ]
);

$dependencyProvider = new DependencyProvider();
$locator = new Locator($dependencyProvider, $namespaces);

$di[KernelConstraints::LOCATOR] = $locator;


////////////
var_dump($locator->Config()->getFacade()->get("test", "1234"));
////////////

