<?php

namespace Deployee\Plugins\OxidEshopTasks\Definitions;


use Deployee\Deployment\Definitions\Parameter\ParameterCollection;
use Deployee\Deployment\Definitions\Tasks\AbstractTaskDefinition;

class ModuleDefinition extends AbstractTaskDefinition
{
    const MODE_ACTIVATE = "activate";

    const MODE_DEACTIVATE = "deactivate";

    /**
     * @var string
     */
    private $moduleId;

    /**
     * @var string
     */
    private $mode;

    /**
     * @var array
     */
    private $shopIds;

    /**
     * ModuleTask constructor.
     * @param string $moduleId
     */
    public function __construct($moduleId)
    {
        $this->moduleId = $moduleId;
        $this->mode = "";
        $this->shopIds = [];
    }

    /**
     * @return $this
     */
    public function activate()
    {
        $this->mode = self::MODE_ACTIVATE;
        return $this;
    }

    /**
     * @return $this
     */
    public function deactivate()
    {
        $this->mode = self::MODE_DEACTIVATE;
        return $this;
    }

    /**
     * @param $shopId
     * @return $this
     */
    public function forShopId($shopId)
    {
        $this->shopIds[] = $shopId;
        return $this;
    }

    /**
     * @return ParameterCollection
     */
    public function define()
    {
        if($this->mode === ''){
            throw new \LogicException("You must use activate() or deactivate() method to define module state");
        }

        return new ParameterCollection([
            'mode' => $this->mode,
            'shopids' => $this->shopIds,
            'moduleid' => $this->moduleId
        ]);
    }
}