<?php


namespace Deployee\Dependency;


use Deployee\ClassLoader\Facade;
use Deployee\Kernel\Modules\Module;

class DependencyModule extends Module
{
    /**
     * @inheritdoc
     */
    public function onLoad()
    {
        list($dependencyProvider, $dependencyInjectionProvider) = $this->locateProviderClasses();
        $this->runDependencyProvider($dependencyProvider);
        $this->runDependencyInjectionProvider($dependencyInjectionProvider);
    }

    /**
     * @param array $dependencyProvider
     */
    private function runDependencyInjectionProvider(array $dependencyProvider)
    {
        foreach($dependencyProvider as $className){
            /* @var DependencyInjectionProviderInterface $provider */
            if(($provider = new $className) instanceof DependencyInjectionProviderInterface){
                $provider->injectDependencies($this->getLocator());
            }
        }
    }

    /**
     * @param array $dependencyProvider
     */
    private function runDependencyProvider(array $dependencyProvider)
    {
        foreach($dependencyProvider as $className){
            /* @var DependencyProviderInterface $provider */
            if(($provider = new $className) instanceof DependencyProviderInterface){
                $provider->defineDependencies($this->getLocator());
            }
        }
    }

    /**
     * @return array
     */
    private function locateProviderClasses()
    {
        /* @var Facade $classLoaderFacade */
        $classLoaderFacade = $this->getLocator()->ClassLoader()->getFacade();
        $dependencyProvider = [];
        $dependencyInjectionProvider = [];
        foreach($classLoaderFacade->getPrefixesPsr4() as $namespace => $prefixes){
            $dependencyProvider = array_merge(
                $dependencyProvider,
                $this->locateDependencyClasses($namespace, $prefixes, 'DependencyProvider')
            );

            $dependencyInjectionProvider = array_merge(
                $dependencyInjectionProvider,
                $this->locateDependencyClasses($namespace, $prefixes, 'DependencyInjectionProvider')
            );
        }

        return [$dependencyProvider, $dependencyInjectionProvider];
    }

    /**
     * @param string $namespace
     * @param array $prefixes
     * @param string $suffix
     * @return array
     */
    private function locateDependencyClasses($namespace, array $prefixes, $suffix)
    {
        $found = [];
        foreach($prefixes as $prefix){
            $found = array_merge($found, $this->locateInDirectory($namespace, $prefix, $suffix));
        }

        return $found;
    }

    /**
     * @param string $namespace
     * @param string $directory
     * @param $suffix
     * @return array
     */
    private function locateInDirectory($namespace, $directory, $suffix)
    {
        $found = [];
        foreach(new \DirectoryIterator($directory) as $item){
            if($item->isDot() || !$item->isDir()){
                continue;
            }

            $basename = $item->getBasename();
            $expectedClassNames = [
                "{$namespace}{$basename}\\{$basename}{$suffix}",
                "{$namespace}{$basename}\\{$suffix}",
                "{$namespace}{$basename}\\Dependency\\{$basename}{$suffix}",
                "{$namespace}{$basename}\\Dependency\\{$suffix}"
            ];

            foreach($expectedClassNames as $expectedClassName){
                if(class_exists($expectedClassName)){
                    $found[] = $expectedClassName;
                    continue;
                }
            }
        }

        return $found;
    }
}