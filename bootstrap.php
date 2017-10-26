<?php
/**
 * Bootstrap file for Deployee task runner
 */

use Composer\Autoload\ClassLoader;
use Deployee\ClassLoader\ClassLoaderModule;
use Deployee\Kernel\DependencyProviderContainer;
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
$namespaces = array_reverse(array_keys($loader->getPrefixesPsr4()));

$dependencyProvider = new DependencyProviderContainer();
$locator = new Locator($dependencyProvider, $namespaces);

$dependencyProvider[KernelConstraints::LOCATOR] = $locator;
$dependencyProvider[ClassLoaderModule::CLASS_LOADER_CONTAINER_ID] = $loader;


////////////
var_dump($locator->Dependency());
////////////

