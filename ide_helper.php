<?php

use Deployee\Plugins\DeployDb\Tasks\MySqlDumpTask;
use Deployee\Plugins\DeployDb\Tasks\MySqlExecuteCommandTask;
use Deployee\Plugins\DeployDb\Tasks\MySqlFileImportTask;
use Deployee\Plugins\DeployFilesystem\Tasks\DirectoryTask;
use Deployee\Plugins\DeployFilesystem\Tasks\FileTask;
use Deployee\Plugins\DeployFilesystem\Tasks\PermissionsTask;
use Deployee\Plugins\DeployOxid\Tasks\ModuleTask;
use Deployee\Plugins\DeployOxid\Tasks\ShopConfigTask;
use Deployee\Plugins\DeployOxid\Tasks\ShopTask;
use Deployee\Plugins\DeployShell\Tasks\ShellTask;

/**
 * THIS TRAIT IS JUST FOR IDE SUPPORT! IT'S NOT BEING USED ANYWHERE ELSE!
 */
trait ideHelperDeploymentDefinition
{
    public function mysqldump($target)
    {
        return new MySqlDumpTask($target);
    }

    public function mysqlfile($source)
    {
        return new MySqlFileImportTask($source);
    }

    public function mysqlcmd($command)
    {
        return new MySqlExecuteCommandTask($command);
    }

    public function directory($path)
    {
        return new DirectoryTask($path);
    }

    public function file($path)
    {
        return new FileTask($path);
    }

    public function permission($path)
    {
        return new PermissionsTask($path);
    }

    public function module($moduleId)
    {
        return new ModuleTask($moduleId);
    }

    public function shop()
    {
        return new ShopTask();
    }

    public function shopConfig($shopId, $varName, $varValue, $varType, $module)
    {
        return new ShopConfigTask($shopId, $varName, $varValue, $varType, $module);
    }

    public function shell($executable)
    {
        return new ShellTask($executable);
    }
}