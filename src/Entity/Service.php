<?php

namespace App\Entity;

use App\Repository\ServiceRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ServiceRepository::class)]
class Service
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $nameservice = null;

    #[ORM\Column(length: 255)]
    private ?string $Description = null;

    /**
     * @var Collection<int, Zoo>
     */
    #[ORM\OneToMany(targetEntity: Zoo::class, mappedBy: 'service')]
    private Collection $Zoo;

    #[ORM\OneToOne(mappedBy: 'service', cascade: ['persist', 'remove'])]
    private ?Role $role = null;

    public function __construct()
    {
        $this->Zoo = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNameservice(): ?string
    {
        return $this->nameservice;
    }

    public function setNameservice(string $nameservice): static
    {
        $this->nameservice = $nameservice;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->Description;
    }

    public function setDescription(string $Description): static
    {
        $this->Description = $Description;

        return $this;
    }

    /**
     * @return Collection<int, Zoo>
     */
    public function getZoo(): Collection
    {
        return $this->Zoo;
    }

    public function addZoo(Zoo $zoo): static
    {
        if (!$this->Zoo->contains($zoo)) {
            $this->Zoo->add($zoo);
            $zoo->setService($this);
        }

        return $this;
    }

    public function removeZoo(Zoo $zoo): static
    {
        if ($this->Zoo->removeElement($zoo)) {
            // set the owning side to null (unless already changed)
            if ($zoo->getService() === $this) {
                $zoo->setService(null);
            }
        }

        return $this;
    }

    public function getRole(): ?Role
    {
        return $this->role;
    }

    public function setRole(?Role $role): static
    {
        // unset the owning side of the relation if necessary
        if ($role === null && $this->role !== null) {
            $this->role->setService(null);
        }

        // set the owning side of the relation if necessary
        if ($role !== null && $role->getService() !== $this) {
            $role->setService($this);
        }

        $this->role = $role;

        return $this;
    }
}
