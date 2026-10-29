<?php

namespace App\DataFixtures;

use App\Entity\Exercice;
use App\Entity\Groupement;
use App\Enum\StatutExercice;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class ExerciceFixtures extends Fixture implements DependentFixtureInterface
{
    public const CLOTURE = 'exercice_cloture';
    public const EN_COURS = 'exercice_en_cours';

    public function load(ObjectManager $manager): void
    {
        $groupement = $this->getReference(GroupementFixtures::GROUPEMENT_SOKHNA, Groupement::class);

        $exerciceCloture = (new Exercice())
            ->setDateDebut(new \DateTime('2025-10-05'))
            ->setDateFin(new \DateTime('2026-10-03'))
            ->setDateLimitePrets(new \DateTime('2026-09-06'))
            ->setDateRetribution(new \DateTime('2026-10-03'))
            ->setStatut(StatutExercice::CLOTURE)
            ->setGroupement($groupement);
        $manager->persist($exerciceCloture);

        $exerciceEnCours = (new Exercice())
            ->setDateDebut(new \DateTime('2026-10-04'))
            ->setDateFin(new \DateTime('2027-10-03'))
            ->setDateLimitePrets(new \DateTime('2027-09-05'))
            ->setDateRetribution(new \DateTime('2027-10-03'))
            ->setStatut(StatutExercice::EN_COURS)
            ->setGroupement($groupement);
        $manager->persist($exerciceEnCours);

        $manager->flush();

        $this->addReference(self::CLOTURE, $exerciceCloture);
        $this->addReference(self::EN_COURS, $exerciceEnCours);
    }

    public function getDependencies(): array
    {
        return [GroupementFixtures::class];
    }
}
