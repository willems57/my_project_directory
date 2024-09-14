<?php

namespace App\Entity;

use App\Repository\AvisRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AvisRepository::class)]
class Avis
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $speudo = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $Comentaire = null;

    #[ORM\Column]
    private ?bool $visible = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSpeudo(): ?string
    {
        return $this->speudo;
    }

    public function setSpeudo(string $speudo): static
    {
        $this->speudo = $speudo;

        return $this;
    }

    public function getComentaire(): ?string
    {
        return $this->Comentaire;
    }

    public function setComentaire(string $Comentaire): static
    {
        $this->Comentaire = $Comentaire;

        return $this;
    }

    public function isVisible(): ?bool
    {
        return $this->visible;
    }

    public function setVisible(bool $visible): static
    {
        $this->visible = $visible;

        return $this;
    }
}
