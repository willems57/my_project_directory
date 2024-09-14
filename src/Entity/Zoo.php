<?php

namespace App\Entity;

use App\Repository\ZooRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ZooRepository::class)]
class Zoo
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 32)]
    private ?string $name = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $Description = null;

    #[ORM\Column(type: Types::ARRAY)]
    private array $amopeningtime = [];

    #[ORM\Column(type: Types::ARRAY)]
    private array $pmopeningtime = [];

    #[ORM\Column]
    private ?int $enclosures = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdat = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $updatedat = null;

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

    public function getDescription(): ?string
    {
        return $this->Description;
    }

    public function setDescription(string $Description): static
    {
        $this->Description = $Description;

        return $this;
    }

    public function getAmopeningtime(): array
    {
        return $this->amopeningtime;
    }

    public function setAmopeningtime(array $amopeningtime): static
    {
        $this->amopeningtime = $amopeningtime;

        return $this;
    }

    public function getPmopeningtime(): array
    {
        return $this->pmopeningtime;
    }

    public function setPmopeningtime(array $pmopeningtime): static
    {
        $this->pmopeningtime = $pmopeningtime;

        return $this;
    }

    public function getEnclosures(): ?int
    {
        return $this->enclosures;
    }

    public function setEnclosures(int $enclosures): static
    {
        $this->enclosures = $enclosures;

        return $this;
    }

    public function getCreatedat(): ?\DateTimeImmutable
    {
        return $this->createdat;
    }

    public function setCreatedat(\DateTimeImmutable $createdat): static
    {
        $this->createdat = $createdat;

        return $this;
    }

    public function getUpdatedat(): ?\DateTimeImmutable
    {
        return $this->updatedat;
    }

    public function setUpdatedat(?\DateTimeImmutable $updatedat): static
    {
        $this->updatedat = $updatedat;

        return $this;
    }
}
