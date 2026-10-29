<?php

namespace App\DataFixtures;

use App\Entity\Fonction;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class FonctionFixtures extends Fixture
{
    public const PRESIDENTE = 'fonction_presidente';
    public const SECRETAIRE = 'fonction_secretaire';
    public const TRESORIERE = 'fonction_tresoriere';
    public const MEMBRE_SIMPLE = 'fonction_membre_simple';

    public function load(ObjectManager $manager): void
    {
        $fonctions = [
            self::PRESIDENTE => 'Présidente',
            self::SECRETAIRE => 'Secrétaire',
            self::TRESORIERE => 'Trésorière',
            self::MEMBRE_SIMPLE => 'Membre simple',
        ];

        foreach ($fonctions as $reference => $nom) {
            $fonction = (new Fonction())->setNom($nom);
            $manager->persist($fonction);
            $this->addReference($reference, $fonction);
        }

        $manager->flush();
    }
}
