<?php

namespace App\Entity;

use App\Repository\RapportsverinairesRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RapportsverinairesRepository::class)]
class Rapportsverinaires
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $date = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $details = null;

    #[ORM\OneToOne(mappedBy: 'Rapportsverinaires', cascade: ['persist', 'remove'])]
    private ?Animals $animals = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDate(): ?\DateTimeImmutable
    {
        return $this->date;
    }

    public function setDate(\DateTimeImmutable $date): static
    {
        $this->date = $date;

        return $this;
    }

    public function getDetails(): ?string
    {
        return $this->details;
    }

    public function setDetails(string $details): static
    {
        $this->details = $details;

        return $this;
    }

    public function getAnimals(): ?Animals
    {
        return $this->animals;
    }

    public function setAnimals(?Animals $animals): static
    {
        // unset the owning side of the relation if necessary
        if ($animals === null && $this->animals !== null) {
            $this->animals->setRapportsverinaires(null);
        }

        // set the owning side of the relation if necessary
        if ($animals !== null && $animals->getRapportsverinaires() !== $this) {
            $animals->setRapportsverinaires($this);
        }

        $this->animals = $animals;

        return $this;
    }
}
