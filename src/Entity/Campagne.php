<?php

namespace App\Entity;

use App\Trait\DateTimeTrait;
use App\Repository\CampagneRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CampagneRepository::class)]
#[ORM\InheritanceType('SINGLE_TABLE')]
#[ORM\DiscriminatorColumn(name: 'type', type: 'string')]
#[ORM\DiscriminatorMap(['tontine' => Tontine::class, 'epargne_calebasse' => EpargneCalebasse::class, 'epargne_duree_precise' => EpargneDureePrecise::class])]
#[ORM\HasLifecycleCallbacks]
abstract class Campagne
{   use DateTimeTrait;
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    private ?string $nom = null;

    #[ORM\Column]
    private ?\DateTime $dateDebut = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTime $dateFin = null;

    #[ORM\Column]
    private ?float $montant = null;

    

    #[ORM\ManyToOne(inversedBy: 'campagnes')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Groupement $groupement = null;

    /**
     * @var Collection<int, Membre>
     */
    #[ORM\ManyToMany(targetEntity: Membre::class, mappedBy: 'campagne')]
    private Collection $membres;

    /**
     * @var Collection<int, Seance>
     */
    #[ORM\OneToMany(targetEntity: Seance::class, mappedBy: 'campagne')]
    private Collection $seances;

    #[ORM\Column]
    private ?int $delaiCotisation = null;

    #[ORM\Column]
    private ?float $montantDer = null;

    #[ORM\Column]
    private ?float $majorationDer = null;

    #[ORM\Column]
    private ?float $amendeJournaliere = null;

    #[ORM\ManyToOne(inversedBy: 'campagnes')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Exercice $exercice = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Periodicite $periodiciteCotisation = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Periodicite $periodiciteRencontre = null;

    public function __construct()
    {
        $this->membres = new ArrayCollection();
        $this->seances = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): static
    {
        $this->nom = $nom;

        return $this;
    }

    public function getDateDebut(): ?\DateTime
    {
        return $this->dateDebut;
    }

    public function setDateDebut(\DateTime $dateDebut): static
    {
        $this->dateDebut = $dateDebut;

        return $this;
    }

    public function getDateFin(): ?\DateTime
    {
        return $this->dateFin;
    }

    public function setDateFin(?\DateTime $dateFin): static
    {
        $this->dateFin = $dateFin;

        return $this;
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

    


    public function getGroupement(): ?Groupement
    {
        return $this->groupement;
    }

    public function setGroupement(?Groupement $groupement): static
    {
        $this->groupement = $groupement;

        return $this;
    }

    /**
     * @return Collection<int, Membre>
     */
    public function getMembres(): Collection
    {
        return $this->membres;
    }

    public function addMembre(Membre $membre): static
    {
        if (!$this->membres->contains($membre)) {
            $this->membres->add($membre);
            $membre->addCampagne($this);
        }

        return $this;
    }

    public function removeMembre(Membre $membre): static
    {
        if ($this->membres->removeElement($membre)) {
            $membre->removeCampagne($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, Seance>
     */
    public function getSeances(): Collection
    {
        return $this->seances;
    }

    public function addSeance(Seance $seance): static
    {
        if (!$this->seances->contains($seance)) {
            $this->seances->add($seance);
            $seance->setCampagne($this);
        }

        return $this;
    }

    public function removeSeance(Seance $seance): static
    {
        if ($this->seances->removeElement($seance)) {
            // set the owning side to null (unless already changed)
            if ($seance->getCampagne() === $this) {
                $seance->setCampagne(null);
            }
        }

        return $this;
    }

    public function getDelaiCotisation(): ?int
    {
        return $this->delaiCotisation;
    }

    public function setDelaiCotisation(int $delaiCotisation): static
    {
        $this->delaiCotisation = $delaiCotisation;

        return $this;
    }

    public function getMontantDer(): ?float
    {
        return $this->montantDer;
    }

    public function setMontantDer(float $montantDer): static
    {
        $this->montantDer = $montantDer;

        return $this;
    }

    public function getMajorationDer(): ?float
    {
        return $this->majorationDer;
    }

    public function setMajorationDer(float $majorationDer): static
    {
        $this->majorationDer = $majorationDer;

        return $this;
    }

    public function getAmendeJournaliere(): ?float
    {
        return $this->amendeJournaliere;
    }

    public function setAmendeJournaliere(float $amendeJournaliere): static
    {
        $this->amendeJournaliere = $amendeJournaliere;

        return $this;
    }

    public function getExercice(): ?Exercice
    {
        return $this->exercice;
    }

    public function setExercice(?Exercice $exercice): static
    {
        $this->exercice = $exercice;

        return $this;
    }

    public function getPeriodiciteCotisation(): ?Periodicite
    {
        return $this->periodiciteCotisation;
    }

    public function setPeriodiciteCotisation(?Periodicite $periodiciteCotisation): static
    {
        $this->periodiciteCotisation = $periodiciteCotisation;

        return $this;
    }

    public function getPeriodiciteRencontre(): ?Periodicite
    {
        return $this->periodiciteRencontre;
    }

    public function setPeriodiciteRencontre(?Periodicite $periodiciteRencontre): static
    {
        $this->periodiciteRencontre = $periodiciteRencontre;

        return $this;
    }
}
