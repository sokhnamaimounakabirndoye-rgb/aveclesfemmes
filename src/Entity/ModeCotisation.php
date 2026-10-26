<?php

namespace App\Entity;

use App\Repository\ModeCotisationRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ModeCotisationRepository::class)]
class ModeCotisation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?bool $islibre = null;

    #[ORM\ManyToOne(inversedBy: 'modeCotisations')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Epargne $epargne = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function islibre(): ?bool
    {
        return $this->islibre;
    }

    public function setIslibre(bool $islibre): static
    {
        $this->islibre = $islibre;

        return $this;
    }

    public function getEpargne(): ?Epargne
    {
        return $this->epargne;
    }

    public function setEpargne(?Epargne $epargne): static
    {
        $this->epargne = $epargne;

        return $this;
    }
}
