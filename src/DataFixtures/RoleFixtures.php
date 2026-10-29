<?php

namespace App\DataFixtures;

use App\Entity\Admin;
use App\Entity\MembreSimple;
use App\Entity\SupAdmin;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class RoleFixtures extends Fixture
{
    public const ADMIN = 'role_admin';
    public const MEMBRE_SIMPLE = 'role_membre_simple';
    public const SUPADMIN = 'role_supadmin';

    public function load(ObjectManager $manager): void
    {
        $admin = (new Admin())->setNom('Admin');
        $membreSimple = (new MembreSimple())->setNom('Membre simple');
        $supAdmin = (new SupAdmin())->setNom('SupAdmin');

        $manager->persist($admin);
        $manager->persist($membreSimple);
        $manager->persist($supAdmin);
        $manager->flush();

        $this->addReference(self::ADMIN, $admin);
        $this->addReference(self::MEMBRE_SIMPLE, $membreSimple);
        $this->addReference(self::SUPADMIN, $supAdmin);
    }
}
