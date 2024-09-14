<?php

namespace App\Entity;

use App\Repository\AnimalsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AnimalsRepository::class)]
class Animals
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    private ?string $etat = null;

    #[ORM\OneToOne(inversedBy: 'animals', cascade: ['persist', 'remove'])]
    private ?rapportsverinaires $Rapportsverinaires = null;

    #[ORM\ManyToOne(inversedBy: 'animals')]
    private ?Picture $Picture = null;

    #[ORM\ManyToOne(inversedBy: 'Animals')]
    private ?Habitat $habitat = null;

    /**
     * @var Collection<int, Race>
     */
    #[ORM\OneToMany(targetEntity: Race::class, mappedBy: 'animals')]
    private Collection $Race;

    public function __construct()
    {
        $this->Race = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getEtat(): ?string
    {
        return $this->etat;
    }

    public function setEtat(string $etat): static
    {
        $this->etat = $etat;

        return $this;
    }

    public function getRapportsverinaires(): ?rapportsverinaires
    {
        return $this->Rapportsverinaires;
    }

    public function setRapportsverinaires(?rapportsverinaires $Rapportsverinaires): static
    {
        $this->Rapportsverinaires = $Rapportsverinaires;

        return $this;
    }

    public function getPicture(): ?Picture
    {
        return $this->Picture;
    }

    public function setPicture(?Picture $Picture): static
    {
        $this->Picture = $Picture;

        return $this;
    }

    public function getHabitat(): ?Habitat
    {
        return $this->habitat;
    }

    public function setHabitat(?Habitat $habitat): static
    {
        $this->habitat = $habitat;

        return $this;
    }

    /**
     * @return Collection<int, Race>
     */
    public function getRace(): Collection
    {
        return $this->Race;
    }

    public function addRace(Race $race): static
    {
        if (!$this->Race->contains($race)) {
            $this->Race->add($race);
            $race->setAnimals($this);
        }

        return $this;
    }

    public function removeRace(Race $race): static
    {
        if ($this->Race->removeElement($race)) {
            // set the owning side to null (unless already changed)
            if ($race->getAnimals() === $this) {
                $race->setAnimals(null);
            }
        }

        return $this;
    }
}
