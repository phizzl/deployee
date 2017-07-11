<?php

use Phizzl\Deployee\Plugins\DeployDb\Tasks\MySqlDumpTask;
use Phizzl\Deployee\Plugins\DeployDb\Tasks\MySqlFileImportTask;
use Phizzl\Deployee\Plugins\DeployFilesystem\Tasks\DirectoryTask;
use Phizzl\Deployee\Plugins\DeployFilesystem\Tasks\FileTask;
use Phizzl\Deployee\Plugins\DeployFilesystem\Tasks\PermissionsTask;
use Phizzl\Deployee\Plugins\DeployOxid\Tasks\ModuleTask;
use Phizzl\Deployee\Plugins\DeployOxid\Tasks\ShopTask;
use Phizzl\Deployee\Plugins\DeployShell\Tasks\ShellTask;

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

    public function shell($executable)
    {
        return new ShellTask($executable);
    }
}