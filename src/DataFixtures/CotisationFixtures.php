<?php

namespace App\DataFixtures;

use App\Entity\Cotisation;
use App\Entity\Membre;
use App\Entity\Seance;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class CotisationFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        // Tontine : montant imposé (10 000) pour tout le monde
        foreach ([MembreFixtures::AWA, MembreFixtures::FATOU, MembreFixtures::MARIAMA, MembreFixtures::KHADY] as $membre) {
            $this->creerCotisation($manager, $membre, SeanceFixtures::TONTINE_1, '2026-10-04', 10000);
        }

        // Épargne calebasse : montant fixe 5 000, sauf Fatou (montant libre)
        $datesCalebasse = ['2026-10-04', '2026-10-11', '2026-10-18', '2026-10-25'];
        $montantsFatou = [2000, 3000, 2000, 2500];

        foreach ($datesCalebasse as $index => $date) {
            $seance = SeanceFixtures::CALEBASSE_PREFIX . ($index + 1);
            $this->creerCotisation($manager, MembreFixtures::AWA, $seance, $date, 5000);
            $this->creerCotisation($manager, MembreFixtures::FATOU, $seance, $date, $montantsFatou[$index]);
            $this->creerCotisation($manager, MembreFixtures::MARIAMA, $seance, $date, 5000);
            $this->creerCotisation($manager, MembreFixtures::KHADY, $seance, $date, 5000);
        }

        // Épargne à durée précise : montant fixe 3 000, sauf Mariama (montant libre)
        $datesDuree = ['2026-10-11', '2026-10-25'];
        $montantsMariama = [1500, 2000];

        foreach ($datesDuree as $index => $date) {
            $seance = SeanceFixtures::DUREE_PREFIX . ($index + 1);
            $this->creerCotisation($manager, MembreFixtures::FATOU, $seance, $date, 3000);
            $this->creerCotisation($manager, MembreFixtures::MARIAMA, $seance, $date, $montantsMariama[$index]);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            SeanceFixtures::class,
            MembreFixtures::class,
        ];
    }

    private function creerCotisation(ObjectManager $manager, string $referenceMembre, string $referenceSeance, string $date, float $montant): void
    {
        $cotisation = (new Cotisation())
            ->setMontant($montant)
            ->setDateCotisation(new \DateTime($date))
            ->setMembre($this->getReference($referenceMembre, Membre::class))
            ->setSeance($this->getReference($referenceSeance, Seance::class));
        $manager->persist($cotisation);
    }
}
