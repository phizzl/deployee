<?php

namespace Deployee\Plugins\DeployShopware\Tasks;


use Deployee\Collection;
use Deployee\Tasks\TaskInterface;

class CreateAdminTask implements TaskInterface
{
    /**
     * @var string
     */
    private $email;

    /**
     * @var string
     */
    private $fullName;

    /**
     * @var string
     */
    private $username;

    /**
     * @var string
     */
    private $password;

    /**
     * @var string
     */
    private $locale;

    /**
     * CreateAdminTask constructor.
     * @param string $email
     * @param string $fullName
     * @param string $username
     * @param string $password
     * @param string $locale
     */
    public function __construct($email, $fullName, $username, $password, $locale = 'en_GB')
    {
        $this->email = $email;
        $this->fullName = $fullName;
        $this->username = $username;
        $this->password = $password;
        $this->locale = $locale;
    }

    /**
     * @return Collection
     */
    public function getDefinition()
    {
        return new Collection([
            'email' => $this->email,
            'fullname' => $this->fullName,
            'username' => $this->username,
            'password' => $this->password,
            'locale' => $this->locale
        ]);
    }
}