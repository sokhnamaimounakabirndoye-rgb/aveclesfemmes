<?php

namespace App\Entity;

use App\Repository\EpargneRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EpargneRepository::class)]
class Epargne extends Campagne
{
    /**
     * @var Collection<int, ModeCotisation>
     */
    #[ORM\OneToMany(targetEntity: ModeCotisation::class, mappedBy: 'epargne')]
    private Collection $modeCotisations;

    public function __construct()
    {
        parent::__construct();
        $this->modeCotisations = new ArrayCollection();
    }

    /**
     * @return Collection<int, ModeCotisation>
     */
    public function getModeCotisations(): Collection
    {
        return $this->modeCotisations;
    }

    public function addModeCotisation(ModeCotisation $modeCotisation): static
    {
        if (!$this->modeCotisations->contains($modeCotisation)) {
            $this->modeCotisations->add($modeCotisation);
            $modeCotisation->setEpargne($this);
        }

        return $this;
    }

    public function removeModeCotisation(ModeCotisation $modeCotisation): static
    {
        if ($this->modeCotisations->removeElement($modeCotisation)) {
            // set the owning side to null (unless already changed)
            if ($modeCotisation->getEpargne() === $this) {
                $modeCotisation->setEpargne(null);
            }
        }

        return $this;
    }
}