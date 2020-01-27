<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class Token
 * Permet de se faire une demande de token par l'interface de documentation
 * @package App\Entity
 */
class Token
{

    /**
     * @var string
     */
    private $email;

    /**
     * @var string
     */
    private $password;



    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @param string $password
     */
    public function setPassword(string $password): void
    {
        $this->password = $password;
    }


}
