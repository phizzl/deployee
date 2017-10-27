<?php

namespace Deployee\Plugins\DeployOxid\Tasks;


use Deployee\Collection;
use Deployee\Tasks\TaskInterface;

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
     * @var array
     */
    private $adminUser;

    /**
     * ShopTask constructor.
     */
    public function __construct()
    {
        $this->clearTmp = false;
        $this->generateViews = false;
        $this->adminUser = [];
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
     * @param string $username
     * @param string $password
     * @return $this
     */
    public function createAdminUser($username, $password)
    {
        $this->adminUser[] = ["username" => $username, "password" => $password];
        return $this;
    }

    /**
     * @return Collection
     */
    public function getDefinition()
    {
        return new Collection([
            'cleartmp' => $this->clearTmp,
            'generateviews' => $this->generateViews,
            'adminuser' => $this->adminUser
        ]);
    }

}