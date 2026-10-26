<?php

namespace App\Entity;

use App\Repository\CotisationRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CotisationRepository::class)]
class Cotisation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?float $montant = null;

    #[ORM\Column]
    private ?\DateTime $dateCotisation = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMontant(): ?float
    {
        return $this->montant;
    }

    public function setMontant(float $montant): static
    {
        $this->montant = $montant;

        return $this;
    }

    public function getDateCotisation(): ?\DateTime
    {
        return $this->dateCotisation;
    }

    public function setDateCotisation(\DateTime $dateCotisation): static
    {
        $this->dateCotisation = $dateCotisation;

        return $this;
    }
}
