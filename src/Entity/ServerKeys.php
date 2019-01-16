<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\OneToOne;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ServerKeysRepository")
 */
class ServerKeys
{
    public function __construct($keyToCreate, $serverId)
    {
        $this->setHash($keyToCreate);
        $this->setServerId($serverId);
        $this->setUploadedAt(new \DateTime());
        $this->setValid(false);
    }
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    public $id;

    /**
     * @ORM\Column(type="integer")
     * @OneToOne(targetEntity="Server")
     */
    public $serverId;

    /**
     * @ORM\Column(type="text")
     */
    private $hash;

    /**
     * @ORM\Column(type="datetime")
     */
    public $uploadedAt;

    /**
     * @ORM\Column(type="boolean", options={"default":0})
     */
    public $valid = false;

    public function getId() : ? int
    {
        return $this->id;
    }

    public function getServerId() : ? int
    {
        return $this->serverId;
    }

    public function setServerId(int $serverId) : self
    {
        $this->serverId = $serverId;

        return $this;
    }

    // public function getHash() : ? string
    // {
    //     return $this->hash;
    // }

    public function setHash(string $hash) : self
    {
        $this->hash = $hash;

        return $this;
    }

    public function getUploadedAt() : ? \DateTimeInterface
    {
        return $this->uploadedAt;
    }

    public function setUploadedAt(\DateTimeInterface $uploadedAt) : self
    {
        $this->uploadedAt = $uploadedAt;

        return $this;
    }

    public function getValid() : ? bool
    {
        return $this->valid;
    }

    public function setValid(bool $valid) : self
    {
        $this->valid = $valid;

        return $this;
    }
}
