<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ServiceRepository")
 */
class Service
{
    public function __construct($serviceToCreate, $owner)
    {
        $this->setAddress("192.168.56.102");
        $this->setName($serviceToCreate->name);
        $this->setOwner($owner);
        $this->setReplicas($serviceToCreate->replicas);
        $this->setfileBase64($serviceToCreate->fileBase64);
        $this->setType($serviceToCreate->type);
        $this->setPort("EMPTY");
        $this->dependencies = new ArrayCollection();
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
     * @ORM\Column(type="string", length=255)
     */
    public $address;

    /**
     * @ORM\Column(type="integer")
     */
    public $replicas;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User")
     * @ORM\JoinColumn(nullable=false)
     */
    private $owner;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    public $serviceId;

    /**
     * @ORM\Column(type="string", length=255)
     */
    public $fileBase64;

    /**
     * @ORM\Column(type="string", length=255)
     */
    public $type;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Dependency", inversedBy="services")
     */
    public $dependencies;

    /**
     * @ORM\Column(type="string", length=255)
     */
    public $port;

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

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(string $address): self
    {
        $this->address = $address;

        return $this;
    }

    public function getReplicas(): ?int
    {
        return $this->replicas;
    }

    public function setReplicas(int $replicas): self
    {
        $this->replicas = $replicas;

        return $this;
    }

    public function getOwner(): ?User
    {
        return $this->owner;
    }

    public function setOwner(?User $owner): self
    {
        $this->owner = $owner;

        return $this;
    }

    public function getServiceId(): ?string
    {
        return $this->serviceId;
    }

    public function setServiceId(?string $serviceId): self
    {
        $this->serviceId = $serviceId;

        return $this;
    }

    public function getfileBase64(): ?string
    {
        return $this->fileBase64;
    }

    public function setfileBase64(string $fileBase64): self
    {
        $this->fileBase64 = $fileBase64;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

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

    /**
     * @return Collection|Dependency[]
     */
    public function getDependencies(): Collection
    {
        $toReturn = new ArrayCollection();
        foreach ($this->dependencies as $dep) {
            $toReturn[] = [
                "version" => $dep->version,
                "name" => $dep->name,
                "lang" => $dep->lang
            ];
        }
        return $toReturn;
        // return $this->dependencies;
    }

    public function addDependency(Dependency $dependency): self
    {
        if (!$this->dependencies->contains($dependency)) {
            $this->dependencies[] = $dependency;
        }

        return $this;
    }

    public function removeDependency(Dependency $dependency): self
    {
        if ($this->dependencies->contains($dependency)) {
            $this->dependencies->removeElement($dependency);
        }

        return $this;
    }
}
