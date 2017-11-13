<?php

class ideHelperDeploymentDefinition
{
        /**
     * @return Deployee\Plugins\FilesystemTasks\Definitions\DirectoryTaskDefinition
     */
    public function directory($path)
    {
        return new Deployee\Plugins\FilesystemTasks\Definitions\DirectoryTaskDefinition($path);
    }

    /**
     * @return Deployee\Plugins\FilesystemTasks\Definitions\FileTaskDefinition
     */
    public function file($path)
    {
        return new Deployee\Plugins\FilesystemTasks\Definitions\FileTaskDefinition($path);
    }

    /**
     * @return Deployee\Plugins\MySqlTasks\Definitions\MySqlFileDefinition
     */
    public function mysqlfile($source)
    {
        return new Deployee\Plugins\MySqlTasks\Definitions\MySqlFileDefinition($source);
    }

    /**
     * @return Deployee\Plugins\MySqlTasks\Definitions\MySqlQueryDefinition
     */
    public function mysqlquery($query)
    {
        return new Deployee\Plugins\MySqlTasks\Definitions\MySqlQueryDefinition($query);
    }

    /**
     * @return Deployee\Plugins\OxidEshopTasks\Definitions\ClearShopTempDefinition
     */
    public function oxidcleartmp()
    {
        return new Deployee\Plugins\OxidEshopTasks\Definitions\ClearShopTempDefinition();
    }

    /**
     * @return Deployee\Plugins\OxidEshopTasks\Definitions\GenerateViewsDefinition
     */
    public function oxidgenerateviews()
    {
        return new Deployee\Plugins\OxidEshopTasks\Definitions\GenerateViewsDefinition();
    }

    /**
     * @return Deployee\Plugins\OxidEshopTasks\Definitions\CreateAdminUserDefinition
     */
    public function oxidcreateadminuser($username, $password)
    {
        return new Deployee\Plugins\OxidEshopTasks\Definitions\CreateAdminUserDefinition($username, $password);
    }

    /**
     * @return Deployee\Plugins\OxidEshopTasks\Definitions\ConfigDatabaseDefinition
     */
    public function oxidconfigdatabase($shopId, $varName, $varValue, $varType, $module = "")
    {
        return new Deployee\Plugins\OxidEshopTasks\Definitions\ConfigDatabaseDefinition($shopId, $varName, $varValue, $varType, $module = "");
    }

    /**
     * @return Deployee\Plugins\OxidEshopTasks\Definitions\LanguageKeyDefinition
     */
    public function oxidlangkey($langAbbr, $key, $value)
    {
        return new Deployee\Plugins\OxidEshopTasks\Definitions\LanguageKeyDefinition($langAbbr, $key, $value);
    }

    /**
     * @return Deployee\Plugins\OxidEshopTasks\Definitions\ModuleDefinition
     */
    public function oxidmodule($moduleId)
    {
        return new Deployee\Plugins\OxidEshopTasks\Definitions\ModuleDefinition($moduleId);
    }

    /**
     * @return Deployee\Plugins\OxidEshopTasks\Compatibility\BackwardsCompatibilityDefinition
     */
    public function oxidshop()
    {
        return new Deployee\Plugins\OxidEshopTasks\Compatibility\BackwardsCompatibilityDefinition();
    }

    /**
     * @return Deployee\Plugins\OxidEshopTasks\Definitions\LanguageKeyDefinition
     */
    public function oxidshoplangkey($langAbbr, $key, $value)
    {
        return new Deployee\Plugins\OxidEshopTasks\Definitions\LanguageKeyDefinition($langAbbr, $key, $value);
    }

    /**
     * @return Deployee\Plugins\OxidEshopTasks\Definitions\ConfigDatabaseDefinition
     */
    public function oxidshopconfig($shopId, $varName, $varValue, $varType, $module = "")
    {
        return new Deployee\Plugins\OxidEshopTasks\Definitions\ConfigDatabaseDefinition($shopId, $varName, $varValue, $varType, $module = "");
    }

    /**
     * @return Deployee\Plugins\OxidEshopTasks\Compatibility\BackwardsCompatibilityDefinition
     */
    public function shop()
    {
        return new Deployee\Plugins\OxidEshopTasks\Compatibility\BackwardsCompatibilityDefinition();
    }

    /**
     * @return Deployee\Plugins\OxidEshopTasks\Definitions\ModuleDefinition
     */
    public function module($moduleId)
    {
        return new Deployee\Plugins\OxidEshopTasks\Definitions\ModuleDefinition($moduleId);
    }

    /**
     * @return Deployee\Plugins\OxidEshopTasks\Definitions\ConfigDatabaseDefinition
     */
    public function shopconfig($shopId, $varName, $varValue, $varType, $module = "")
    {
        return new Deployee\Plugins\OxidEshopTasks\Definitions\ConfigDatabaseDefinition($shopId, $varName, $varValue, $varType, $module = "");
    }

    /**
     * @return Deployee\Plugins\ShellTasks\Definitions\ShellTaskDefinition
     */
    public function shell($executable)
    {
        return new Deployee\Plugins\ShellTasks\Definitions\ShellTaskDefinition($executable);
    }
}