<?php
/**
 * Bootstrap file for Deployee task runner
 */

use Composer\Autoload\ClassLoader;
use Deployee\ClassLoader\Module;
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

$dependencyProviderContainer = new DependencyProviderContainer();
$locator = new Locator($dependencyProviderContainer, $namespaces);

$dependencyProviderContainer[Module::CLASS_LOADER_CONTAINER_ID] = $loader;
$dependencyProviderContainer[KernelConstraints::LOCATOR] = $locator;

return $locator;