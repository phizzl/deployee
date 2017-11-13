<?php


namespace Deployee\Plugins\History;


use Deployee\Dependency\DependencyInjectionProviderInterface;
use Deployee\Kernel\Locator;
use Deployee\Plugins\History\Subscriber\FindExecutableDefinitionsSubscriber;
use Deployee\Plugins\History\Subscriber\InstallSubscriber;
use Deployee\Plugins\History\Subscriber\PostDispatchDeploymentSubscriber;
use Deployee\Plugins\History\Subscriber\PreAddDeploymentToHistorySubscriber;

class DependencyInjectionProvider implements DependencyInjectionProviderInterface
{
    /**
     * @param Locator $locator
     */
    public function injectDependencies(Locator $locator)
    {
        $locator->Events()->addSubscriber(new InstallSubscriber($locator));
        $locator->Events()->addSubscriber(new FindExecutableDefinitionsSubscriber($locator));
        $locator->Events()->addSubscriber(new PostDispatchDeploymentSubscriber($locator));
        $locator->Events()->addSubscriber(new PreAddDeploymentToHistorySubscriber($locator));
    }

}