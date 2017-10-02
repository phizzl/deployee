<?php

namespace Deployee\Plugins\DeployOxid\Tasks;


use Deployee\Collection;
use Deployee\Tasks\TaskInterface;

class ShopConfigTask implements TaskInterface
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
     * @return Collection
     */
    public function getDefinition()
    {
        return new Collection([
            'varname' => $this->varName,
            'vartype' => $this->varType,
            'shopid' => $this->shopId,
            'value' => $this->value,
            'module' => $this->module
        ]);
    }

}