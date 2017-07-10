<?php

namespace Phizzl\Deployee\Plugins\DeployOxid\Tasks;


use Phizzl\Deployee\Collection;
use Phizzl\Deployee\Tasks\TaskInterface;

class ShopTask implements TaskInterface
{
    /**
     * @var bool
     */
    private $clearTmp;

    /**
     * @var bool
     */
    private $generateViews;

    /**
     * ShopTask constructor.
     */
    public function __construct()
    {
        $this->clearTmp = false;
        $this->generateViews = false;
    }

    /**
     * @return $this
     */
    public function clearTmp()
    {
        $this->clearTmp = true;
        return $this;
    }

    /**
     * @return $this
     */
    public function generateViews()
    {
        $this->generateViews = true;
        return $this;
    }

    /**
     * @return Collection
     */
    public function getDefinition()
    {
        return new Collection([
            'cleartmp' => $this->clearTmp,
            'generateviews' => $this->generateViews
        ]);
    }

}