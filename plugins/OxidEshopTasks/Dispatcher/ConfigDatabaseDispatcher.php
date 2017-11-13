<?php

namespace Deployee\Plugins\OxidEshopTasks\Dispatcher;


use Deployee\Deployment\Definitions\Tasks\TaskDefinitionInterface;
use Deployee\Plugins\MySqlTasks\Definitions\MySqlQueryDefinition;
use Deployee\Plugins\OxidEshopTasks\Definitions\ConfigDatabaseDefinition;
use Deployee\Plugins\RunDeploy\Dispatcher\AbstractTaskDefinitionDispatcher;
use Deployee\Plugins\RunDeploy\Dispatcher\DispatchResultInterface;

class ConfigDatabaseDispatcher extends AbstractTaskDefinitionDispatcher
{
    /**
     * @param TaskDefinitionInterface $taskDefinition
     * @return bool
     */
    public function canDispatchTaskDefinition(TaskDefinitionInterface $taskDefinition)
    {
        return $taskDefinition instanceof ConfigDatabaseDefinition;
    }

    /**
     * @param TaskDefinitionInterface $taskDefinition
     * @return DispatchResultInterface
     */
    public function dispatch(TaskDefinitionInterface $taskDefinition)
    {
        $oxidConfigKey = "fq45QS09_fqyx09239QQ";
        $parameter = $taskDefinition->define();
        $varname = $parameter->get('varname');
        $vartype = $parameter->get('vartype');
        $shopid = $parameter->get('shopid');
        $value = $parameter->get('value');
        $module = $parameter->get('module');

        $sql = "DELETE FROM oxconfig WHERE oxvarname='{$varname}' AND oxshopid='{$shopid}' AND oxmodule='{$module}';\n";

        switch ($vartype){
            case "arr": $value = is_array($value) ? serialize(array_values($value)) : $value; break;
            case "aarr": $value = is_array($value) ? serialize($value) : $value; break;
            case "bool": $value = !is_int($value) && (bool)$value === true ? 1 : 0; break;
            case "num": $value = (int)$value; break;
        }

        $uid = md5(uniqid("", true) . rand(1, 99999));
        $sql .= "REPLACE INTO oxconfig (oxid, oxshopid, oxvarname, oxvartype, oxmodule, oxvarvalue) " .
            "VALUES ('{$uid}', '{$shopid}', '{$varname}', '{$vartype}', '{$module}', ENCODE('{$value}', '{$oxidConfigKey}'));\n";

        $mysqlTask = new MySqlQueryDefinition($sql);
        return $this->delegate($mysqlTask);
    }
}