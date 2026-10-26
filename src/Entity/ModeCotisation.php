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
}
