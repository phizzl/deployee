<?php

namespace Deployee\Plugins\ShopwareTasks\Definitions;


use Deployee\Deployment\Definitions\Parameter\ParameterCollection;
use Deployee\Deployment\Definitions\Tasks\AbstractTaskDefinition;

class GenerateThemeCacheDefinition extends AbstractTaskDefinition
{
    /**
     * @var int
     */
    private $shopId;

    /**
     * GenerateThemeCacheDefinition constructor.
     * @param int $shopId
     */
    public function __construct(array $shopId)
    {
        $this->shopId = $shopId;
    }

    /**
     * @return ParameterCollection
     */
    public function define()
    {
        return new ParameterCollection(get_object_vars($this));
    }
}