<?php

namespace App\Model\User\Security;

/**
 * Modelo para recuperar contraseña
 *
 * @author Máximo Sojo <maxsojo13@gmail.com>
 */
class ModelResetting
{
    /**
     * @var string
     */
    private $country;

    /**
     * @var string
     */
    private $username;

    public function setCountry($country)
    {
        $this->country = $country;
        return $this;
    }

    public function getCountry()
    {
        return $this->country;
    }

    public function setUsername($username)
    {
        $this->username = $username;
        return $this;
    }

    public function getUsername()
    {
        return $this->username;
    }
}
