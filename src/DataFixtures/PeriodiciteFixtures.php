<?php

namespace App\DataFixtures;

use App\Entity\Periodicite;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class PeriodiciteFixtures extends Fixture
{
    public const HEBDOMADAIRE = 'periodicite_hebdomadaire';
    public const MENSUELLE = 'periodicite_mensuelle';
    public const BIMENSUELLE = 'periodicite_bimensuelle';
    public const QUINZAINE = 'periodicite_quinzaine';

    public function load(ObjectManager $manager): void
    {
        $periodicites = [
            self::HEBDOMADAIRE => 'Hebdomadaire',
            self::MENSUELLE => 'Mensuelle',
            self::BIMENSUELLE => 'Bimensuelle',
            self::QUINZAINE => 'Quinzaine',
        ];

        foreach ($periodicites as $reference => $nom) {
            $periodicite = (new Periodicite())->setNom($nom);
            $manager->persist($periodicite);
            $this->addReference($reference, $periodicite);
        }

        $manager->flush();
    }
}
