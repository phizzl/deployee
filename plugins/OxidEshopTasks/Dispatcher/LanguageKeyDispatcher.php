<?php

namespace Deployee\Plugins\OxidEshopTasks\Dispatcher;


use Deployee\Deployment\Definitions\Tasks\TaskDefinitionInterface;
use Deployee\Plugins\FilesystemTasks\Definitions\FileTaskDefinition;
use Deployee\Plugins\OxidEshopTasks\Definitions\LanguageKeyDefinition;
use Deployee\Plugins\RunDeploy\Dispatcher\AbstractTaskDefinitionDispatcher;
use Deployee\Plugins\RunDeploy\Dispatcher\DispatchResultInterface;

class LanguageKeyDispatcher extends AbstractTaskDefinitionDispatcher
{
    /**
     * @param TaskDefinitionInterface $taskDefinition
     * @return bool
     */
    public function canDispatchTaskDefinition(TaskDefinitionInterface $taskDefinition)
    {
        return $taskDefinition instanceof LanguageKeyDefinition;
    }

    /**
     * @param TaskDefinitionInterface $taskDefinition
     * @return DispatchResultInterface
     */
    public function dispatch(TaskDefinitionInterface $taskDefinition)
    {
        $parameter = $taskDefinition->define();
        $shopPath = realpath($this->locator->Config()->get('oxid.path'));
        $langFilePath = $shopPath . $parameter->get('path');

        $aLang = [];
        if(is_file($langFilePath)){
            include $langFilePath;
        }

        $aLang['charset'] = 'UTF-8';
        $aLang[$parameter->get('key')] = $parameter->get('value');
        $languageArray = var_export($aLang, true);

        $contents = <<<EOF
<?php

    \$sLangName  = "{$parameter->get('langabbr')}";
    \$aLang = {$languageArray};
EOF;

        $fileTask = new FileTaskDefinition($langFilePath);
        $fileTask->contents($contents);

        return $this->delegate($fileTask);
    }
}