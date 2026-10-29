<?php

namespace App\DataFixtures;

use App\Entity\Admin;
use App\Entity\Fonction;
use App\Entity\Groupement;
use App\Entity\Membre;
use App\Entity\MembreSimple;
use App\Entity\Role;
use App\Entity\SupAdmin;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class MembreFixtures extends Fixture implements DependentFixtureInterface
{
    public const AWA = 'membre_awa';
    public const FATOU = 'membre_fatou';
    public const MARIAMA = 'membre_mariama';
    public const KHADY = 'membre_khady';
    public const SUPADMIN = 'membre_supadmin';

    public function load(ObjectManager $manager): void
    {
        $groupement = $this->getReference(GroupementFixtures::GROUPEMENT_SOKHNA, Groupement::class);

        $roleAdmin = $this->getReference(RoleFixtures::ADMIN, Admin::class);
        $roleMembre = $this->getReference(RoleFixtures::MEMBRE_SIMPLE, MembreSimple::class);
        $roleSupAdmin = $this->getReference(RoleFixtures::SUPADMIN, SupAdmin::class);

        $presidente = $this->getReference(FonctionFixtures::PRESIDENTE, Fonction::class);
        $secretaire = $this->getReference(FonctionFixtures::SECRETAIRE, Fonction::class);
        $tresoriere = $this->getReference(FonctionFixtures::TRESORIERE, Fonction::class);
        $simple = $this->getReference(FonctionFixtures::MEMBRE_SIMPLE, Fonction::class);

        $this->creerMembre($manager, self::AWA, 'Awa Diop', '771111111', 'Dakar', 'awa', $groupement, $roleAdmin, $presidente);
        $this->creerMembre($manager, self::FATOU, 'Fatou Ndiaye', '772222222', 'Pikine', 'fatou', $groupement, $roleMembre, $secretaire);
        $this->creerMembre($manager, self::MARIAMA, 'Mariama Sow', '773333333', 'Guédiawaye', 'mariama', $groupement, $roleMembre, $tresoriere);
        $this->creerMembre($manager, self::KHADY, 'Khady Fall', '774444444', 'Rufisque', 'khady', $groupement, $roleMembre, $simple);

        // Le SupAdmin gère la plateforme : aucun groupement, aucune fonction
        $this->creerMembre($manager, self::SUPADMIN, 'Super Administrateur', '775555555', 'Dakar', 'supadmin', null, $roleSupAdmin, null);

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            GroupementFixtures::class,
            FonctionFixtures::class,
            RoleFixtures::class,
        ];
    }

    private function creerMembre(
        ObjectManager $manager,
        string $reference,
        string $nomComplet,
        string $telephone,
        string $addresse,
        string $login,
        ?Groupement $groupement,
        Role $role,
        ?Fonction $fonction
    ): void {
        $membre = (new Membre())
            ->setNomComplet($nomComplet)
            ->setTelephone($telephone)
            ->setAddresse($addresse)
            ->setLogin($login)
            ->setPassword(password_hash('motdepasse', PASSWORD_BCRYPT))
            ->setGroupement($groupement)
            ->setRole($role)
            ->setFonction($fonction);

        $manager->persist($membre);
        $this->addReference($reference, $membre);
    }
}
