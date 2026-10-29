<?php

namespace App\Entity;

use App\Trait\DateTimeTrait;
use App\Repository\CotisationRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CotisationRepository::class)]
#[ORM\HasLifecycleCallbacks]
class Cotisation
{   use DateTimeTrait;
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?float $montant = null;

    #[ORM\Column]
    private ?\DateTime $dateCotisation = null;

    #[ORM\ManyToOne(inversedBy: 'cotisations')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Membre $membre = null;

    #[ORM\ManyToOne(inversedBy: 'cotisations')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Seance $seance = null;

    #[ORM\Column]
    private ?float $montantCaisse = null;

    #[ORM\Column]
    private ?float $montantAmende = null;

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

    public function getMembre(): ?Membre
    {
        return $this->membre;
    }

    public function setMembre(?Membre $membre): static
    {
        $this->membre = $membre;

        return $this;
    }

    public function getSeance(): ?Seance
    {
        return $this->seance;
    }

    public function setSeance(?Seance $seance): static
    {
        $this->seance = $seance;

        return $this;
    }

    public function getMontantCaisse(): ?float
    {
        return $this->montantCaisse;
    }

    public function setMontantCaisse(float $montantCaisse): static
    {
        $this->montantCaisse = $montantCaisse;

        return $this;
    }

    public function getMontantAmende(): ?float
    {
        return $this->montantAmende;
    }

    public function setMontantAmende(float $montantAmende): static
    {
        $this->montantAmende = $montantAmende;

        return $this;
    }
}
