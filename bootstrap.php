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

$dependencyProviderContainer = new DependencyProviderContainer();
$dependencyProviderContainer[ClassLoaderModule::CLASS_LOADER_CONTAINER_ID] = $loader;
$locator = new Locator($dependencyProviderContainer, $namespaces);

$locator->Dependency()->getFacade()->setDependency(KernelConstraints::LOCATOR, $locator);

return $locator;