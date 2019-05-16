<?php

namespace App\Entity;

use Symfony\Component\Validator\Constraints as Assert;

use Doctrine\ORM\Mapping as ORM;


use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Doctrine\ORM\Mapping\OneToOne;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ServerRepository")
 * @UniqueEntity(fields={"ip"}, message="Server with ip {{ value }} already exists")
 */

class Server
{
    public function __construct($serverToCreate)
    {
        $this->setIp($serverToCreate->ip);
        $this->setPort($serverToCreate->port);
        $this->setCreated(new \DateTime());
        $this->setDescription($serverToCreate->description);
        $this->setName($serverToCreate->name);
        $this->setLeader($serverToCreate->leader);
    }
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    public $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    public $name;

    /**
     * @ORM\Column(type="string", length=255, unique=true)
     * @Assert\Ip
     */
    public $ip;

    /**
     * @ORM\Column(type="datetime")
     */
    public $created;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    public $description;

    /**
     * @ORM\Column(type="string", length=255, options={"default":"2377"}))
     */
    public $port = "";

    /**
     * @ORM\Column(type="boolean", options={"default":0})
     */
    public $leader;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getIp(): ?string
    {
        return $this->ip;
    }

    public function setIp(string $ip): self
    {
        $this->ip = $ip;

        return $this;
    }

    public function getCreated(): ?\DateTimeInterface
    {
        return $this->created;
    }

    public function setCreated(\DateTimeInterface $created): self
    {
        $this->created = $created;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getKeyId(): ?int
    {
        return $this->keyId;
    }

    public function setKeyId(?int $keyId): self
    {
        $this->keyId = $keyId;

        return $this;
    }

    public function getPort(): ?string
    {
        return $this->port;
    }

    public function setPort(string $port): self
    {
        $this->port = $port;

        return $this;
    }

    public function getLeader(): ?bool
    {
        return $this->leader;
    }

    public function setLeader(bool $leader): self
    {
        $this->leader = $leader;

        return $this;
    }
}
