<?php

namespace App\DataFixtures;

use App\Entity\EpargneCalebasse;
use App\Entity\EpargneDureePrecise;
use App\Entity\Membre;
use App\Entity\ModeCotisation;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class ModeCotisationFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $calebasse = $this->getReference(CampagneFixtures::CALEBASSE, EpargneCalebasse::class);
        $dureePrecise = $this->getReference(CampagneFixtures::DUREE_PRECISE, EpargneDureePrecise::class);

        // Seules les épargnes ont un mode de cotisation (isLibre) : tontine = montant imposé pour tous
        $modes = [
            [$calebasse, MembreFixtures::AWA, false],
            [$calebasse, MembreFixtures::FATOU, true],
            [$calebasse, MembreFixtures::MARIAMA, false],
            [$calebasse, MembreFixtures::KHADY, false],
            [$dureePrecise, MembreFixtures::FATOU, false],
            [$dureePrecise, MembreFixtures::MARIAMA, true],
        ];

        foreach ($modes as [$epargne, $referenceMembre, $isLibre]) {
            $mode = (new ModeCotisation())
                ->setIslibre($isLibre)
                ->setEpargne($epargne)
                ->setMembre($this->getReference($referenceMembre, Membre::class));
            $manager->persist($mode);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            CampagneFixtures::class,
            MembreFixtures::class,
        ];
    }
}
