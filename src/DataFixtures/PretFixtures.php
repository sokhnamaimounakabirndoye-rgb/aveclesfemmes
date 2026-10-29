<?php

namespace App\DataFixtures;

use App\Entity\Exercice;
use App\Entity\Membre;
use App\Entity\Pret;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class PretFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $exerciceCloture = $this->getReference(ExerciceFixtures::CLOTURE, Exercice::class);
        $exerciceEnCours = $this->getReference(ExerciceFixtures::EN_COURS, Exercice::class);

        // Deux prêts remboursés pendant l'exercice clôturé
        $this->creerPret($manager, MembreFixtures::FATOU, $exerciceCloture, 20000, '2026-06-07', '2026-08-02');
        $this->creerPret($manager, MembreFixtures::KHADY, $exerciceCloture, 10000, '2026-05-03', '2026-07-05');

        // Un prêt en cours : pas encore remboursé
        $this->creerPret($manager, MembreFixtures::MARIAMA, $exerciceEnCours, 15000, '2026-10-11', null);

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            MembreFixtures::class,
            ExerciceFixtures::class,
        ];
    }

    private function creerPret(ObjectManager $manager, string $referenceMembre, Exercice $exercice, float $montant, string $dateDemande, ?string $dateRemboursement): void
    {
        $pret = (new Pret())
            ->setMontant($montant)
            ->setDateDemande(new \DateTime($dateDemande))
            ->setDateRemboursement($dateRemboursement ? new \DateTime($dateRemboursement) : null)
            ->setMembre($this->getReference($referenceMembre, Membre::class))
            ->setExercice($exercice);
        $manager->persist($pret);
    }
}
