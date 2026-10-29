<?php

namespace App\DataFixtures;

use App\Entity\Groupement;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class GroupementFixtures extends Fixture
{
    public const GROUPEMENT_SOKHNA = 'groupement_sokhna';

    public function load(ObjectManager $manager): void
    {
        $groupement = (new Groupement())
            ->setNom('Groupement Sokhna')
            ->setAddresse('Dakar')
            ->setTelephone('770000000');
        $manager->persist($groupement);
        $manager->flush();

        $this->addReference(self::GROUPEMENT_SOKHNA, $groupement);
    }
}
