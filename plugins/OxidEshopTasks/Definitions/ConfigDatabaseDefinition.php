<?php

namespace Deployee\Plugins\OxidEshopTasks\Definitions;


use Deployee\Deployment\Definitions\Parameter\ParameterCollection;
use Deployee\Deployment\Definitions\Tasks\AbstractTaskDefinition;

class ConfigDatabaseDefinition extends AbstractTaskDefinition
{
    /**
     * @var string
     */
    private $varName;

    /**
     * @var string
     */
    private $varType;

    /**
     * @var string
     */
    private $module;

    /**
     * @var string
     */
    private $value;
    /**
     * @var string
     */
    private $shopId;

    /**
     * ShopTask constructor.
     */
    public function __construct($shopId, $varName, $varValue, $varType, $module = "")
    {
        $this->varName = $varName;
        $this->varType = $varType;
        $this->module = $module;
        $this->value = $varValue;
        $this->shopId = $shopId;
    }

    /**
     * @return ParameterCollection
     */
    public function define()
    {
        return new ParameterCollection([
            'varname' => $this->varName,
            'vartype' => $this->varType,
            'shopid' => $this->shopId,
            'value' => $this->value,
            'module' => $this->module
        ]);
    }
}