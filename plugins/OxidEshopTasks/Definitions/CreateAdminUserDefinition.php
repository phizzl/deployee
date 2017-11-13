<?php

namespace Deployee\Plugins\OxidEshopTasks\Definitions;


use Deployee\Deployment\Definitions\Parameter\ParameterCollection;
use Deployee\Deployment\Definitions\Tasks\AbstractTaskDefinition;

class CreateAdminUserDefinition extends AbstractTaskDefinition
{
    /**
     * @var string
     */
    private $username;

    /**
     * @var string
     */
    private $password;

    /**
     * CreateAdminUserDefinition constructor.
     * @param string $username
     * @param string $password
     */
    public function __construct($username, $password)
    {
        $this->username = $username;
        $this->password = $password;
    }

    /**
     * @return ParameterCollection
     */
    public function define()
    {
        return new ParameterCollection([
            'username' => $this->username,
            'password' => $this->password
        ]);
    }
}