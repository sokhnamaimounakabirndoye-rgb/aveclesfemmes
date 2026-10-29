<?php

namespace App\DataFixtures;

use App\Entity\Cotisation;
use App\Entity\EpargneCalebasse;
use App\Entity\EpargneDureePrecise;
use App\Entity\Membre;
use App\Entity\Seance;
use App\Entity\Tontine;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class CotisationFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $tontine = $this->getReference(CampagneFixtures::TONTINE, Tontine::class);
        $calebasse = $this->getReference(CampagneFixtures::CALEBASSE, EpargneCalebasse::class);
        $dureePrecise = $this->getReference(CampagneFixtures::DUREE_PRECISE, EpargneDureePrecise::class);

        $tousLesMembres = [MembreFixtures::AWA, MembreFixtures::FATOU, MembreFixtures::MARIAMA, MembreFixtures::KHADY];

        // Tontine : tout le monde présent, montant imposé (10 000) + caisse sociale
        foreach ($tousLesMembres as $membre) {
            $this->creerCotisation($manager, $membre, SeanceFixtures::TONTINE_1, '2026-10-04', 10000, $tontine->getCaissePresent(), 0);
        }

        // Épargne calebasse : montant fixe 5 000, sauf Fatou (montant libre)
        $datesCalebasse = ['2026-10-04', '2026-10-11', '2026-10-18', '2026-10-25'];
        $montantsFatou = [2000, 3000, 2000, 2500];

        foreach ($datesCalebasse as $index => $date) {
            $seance = SeanceFixtures::CALEBASSE_PREFIX . ($index + 1);
            $numero = $index + 1;

            foreach ($tousLesMembres as $membre) {
                $montant = $membre === MembreFixtures::FATOU ? $montantsFatou[$index] : 5000;
                $caisse = $calebasse->getCaissePresent();
                $amende = 0;

                // Séance 2 : Khady est absente mais a envoyé sa cotisation par une autre membre
                if ($numero === 2 && $membre === MembreFixtures::KHADY) {
                    $caisse = $calebasse->getCaisseAbsent();
                }

                // Séance 3 : Mariama est absente sans cotisation et paie 3 jours plus tard
                // (3 jours d'amende, pas de caisse sociale en plus)
                if ($numero === 3 && $membre === MembreFixtures::MARIAMA) {
                    $caisse = 0;
                    $amende = 3 * $calebasse->getAmendeJournaliere();
                }

                $this->creerCotisation($manager, $membre, $seance, $date, $montant, $caisse, $amende);
            }
        }

        // Épargne à durée précise : montant fixe 3 000, sauf Mariama (montant libre)
        $datesDuree = ['2026-10-11', '2026-10-25'];
        $montantsMariama = [1500, 2000];

        foreach ($datesDuree as $index => $date) {
            $seance = SeanceFixtures::DUREE_PREFIX . ($index + 1);
            $this->creerCotisation($manager, MembreFixtures::FATOU, $seance, $date, 3000, $dureePrecise->getCaissePresent(), 0);
            $this->creerCotisation($manager, MembreFixtures::MARIAMA, $seance, $date, $montantsMariama[$index], $dureePrecise->getCaissePresent(), 0);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            CampagneFixtures::class,
            SeanceFixtures::class,
            MembreFixtures::class,
        ];
    }

    private function creerCotisation(
        ObjectManager $manager,
        string $referenceMembre,
        string $referenceSeance,
        string $date,
        float $montant,
        float $montantCaisse,
        float $montantAmende
    ): void {
        $cotisation = (new Cotisation())
            ->setMontant($montant)
            ->setMontantCaisse($montantCaisse)
            ->setMontantAmende($montantAmende)
            ->setDateCotisation(new \DateTime($date))
            ->setMembre($this->getReference($referenceMembre, Membre::class))
            ->setSeance($this->getReference($referenceSeance, Seance::class));
        $manager->persist($cotisation);
    }
}