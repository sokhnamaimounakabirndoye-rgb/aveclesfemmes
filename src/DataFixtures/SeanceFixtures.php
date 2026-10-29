<?php

namespace App\DataFixtures;

use App\Entity\Campagne;
use App\Entity\EpargneCalebasse;
use App\Entity\EpargneDureePrecise;
use App\Entity\Seance;
use App\Entity\Tontine;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class SeanceFixtures extends Fixture implements DependentFixtureInterface
{
    public const TONTINE_1 = 'seance_tontine_1';
    public const CALEBASSE_PREFIX = 'seance_calebasse_';
    public const DUREE_PREFIX = 'seance_duree_';

    public function load(ObjectManager $manager): void
    {
        $tontine = $this->getReference(CampagneFixtures::TONTINE, Tontine::class);
        $calebasse = $this->getReference(CampagneFixtures::CALEBASSE, EpargneCalebasse::class);
        $dureePrecise = $this->getReference(CampagneFixtures::DUREE_PRECISE, EpargneDureePrecise::class);

        $this->creerSeance($manager, self::TONTINE_1, '2026-10-04', $tontine);

        $datesCalebasse = ['2026-10-04', '2026-10-11', '2026-10-18', '2026-10-25'];
        foreach ($datesCalebasse as $index => $date) {
            $this->creerSeance($manager, self::CALEBASSE_PREFIX . ($index + 1), $date, $calebasse);
        }

        $datesDuree = ['2026-10-11', '2026-10-25'];
        foreach ($datesDuree as $index => $date) {
            $this->creerSeance($manager, self::DUREE_PREFIX . ($index + 1), $date, $dureePrecise);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [CampagneFixtures::class];
    }

    private function creerSeance(ObjectManager $manager, string $reference, string $date, Campagne $campagne): void
    {
        $seance = (new Seance())
            ->setDate(new \DateTime($date))
            ->setCampagne($campagne);
        $manager->persist($seance);
        $this->addReference($reference, $seance);
    }
}