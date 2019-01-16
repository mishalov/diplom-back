<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 */
class User implements UserInterface
{
    public function __construct($userToCreate)
    {
        $this->isActive = true;
        $this->username = $userToCreate->username;
        $this->email = $userToCreate->email;
        $this->name = $userToCreate->name;
        $this->surname = $userToCreate->surname;
    }
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, unique=true,options={"default"= ""})
     */
    private $username = "";

    /**
     * @ORM\Column(type="string", length=255,options={"default"= ""})
     */
    private $name = "";

    /**
     * @ORM\Column(type="string", length=255,options={"default"= ""})
     */
    private $surname = "";

    /**
     * @ORM\Column(type="string", length=255,options={"default"= ""})
     */
    private $password = "";

    /**
     * @ORM\Column(type="boolean")
     */
    private $isActive;

    /**
     * @ORM\Column(type="string", length=255, unique=true,options={"default"= ""})
     */
    private $email = "";

    public function getId() : ? int
    {
        return $this->id;
    }

    public function getUsername() : ? string
    {
        return $this->username;
    }

    public function setUsername(string $username) : self
    {
        $this->username = $username;

        return $this;
    }

    public function getName() : ? string
    {
        return $this->name;
    }

    public function setName(string $name) : self
    {
        $this->name = $name;

        return $this;
    }

    public function getSurname() : ? string
    {
        return $this->surname;
    }

    public function setSurname(string $surname) : self
    {
        $this->surname = $surname;

        return $this;
    }

    public function getPassword() : ? string
    {
        return $this->password;
    }

    public function setPassword(string $password) : self
    {
        $this->password = $password;

        return $this;
    }

    public function getIsActive() : ? bool
    {
        return $this->isActive;
    }

    public function setIsActive(bool $isActive) : self
    {
        $this->isActive = $isActive;

        return $this;
    }

    public function getRoles()
    {
        return array('ROLE_USER');
    }
    public function eraseCredentials()
    {
    }

    public function getSalt()
    {
        return null;
    }

    public function getEmail() : ? string
    {
        return $this->email;
    }

    public function setEmail(string $email) : self
    {
        $this->email = $email;

        return $this;
    }
}
