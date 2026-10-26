<?php

namespace App\DataFixtures;

use App\Entity\Admin;
use App\Entity\Cotisation;
use App\Entity\Epargne;
use App\Entity\Fonction;
use App\Entity\Groupement;
use App\Entity\Membre;
use App\Entity\MembreSimple;
use App\Entity\ModeCotisation;
use App\Entity\Pret;
use App\Entity\Seance;
use App\Entity\Tontine;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // Groupement
        $groupement = (new Groupement())
            ->setNom('Groupement Sokhna')
            ->setAddresse('Dakar')
            ->setTelephone('770000000');
        $manager->persist($groupement);

        // Rôles
        $roleAdmin = (new Admin())->setNom('Admin');
        $roleMembre = (new MembreSimple())->setNom('Membre simple');
        $manager->persist($roleAdmin);
        $manager->persist($roleMembre);

        // Fonctions
        $presidente = (new Fonction())->setNom('Présidente');
        $secretaire = (new Fonction())->setNom('Secrétaire');
        $simple = (new Fonction())->setNom('Membre simple');
        $manager->persist($presidente);
        $manager->persist($secretaire);
        $manager->persist($simple);

        // Membres
        $awa = $this->creerMembre($manager, 'Awa Diop', '771111111', 'Dakar', 'awa', $groupement, $roleAdmin, $presidente);
        $fatou = $this->creerMembre($manager, 'Fatou Ndiaye', '772222222', 'Pikine', 'fatou', $groupement, $roleMembre, $secretaire);
        $mariama = $this->creerMembre($manager, 'Mariama Sow', '773333333', 'Guédiawaye', 'mariama', $groupement, $roleMembre, $simple);

        // Campagnes
        $tontine = (new Tontine())
            ->setNom('Tontine mensuelle')
            ->setDateDebut(new \DateTime('2026-11-01'))
            ->setDateFin(new \DateTime('2027-04-30'))
            ->setMontant(10000)
            ->setCreatedAt(new \DateTimeImmutable())
            ->setGroupement($groupement);
        $manager->persist($tontine);

        $epargne = (new Epargne())
            ->setNom('Épargne du dimanche')
            ->setDateDebut(new \DateTime('2026-11-01'))
            ->setDateFin(null)
            ->setMontant(5000)
            ->setCreatedAt(new \DateTimeImmutable())
            ->setGroupement($groupement);
        $manager->persist($epargne);

        // Participation des membres aux campagnes
        foreach ([$awa, $fatou, $mariama] as $membre) {
            $membre->addCampagne($tontine);
            $membre->addCampagne($epargne);
        }

        // Mode de cotisation (épargne uniquement)
        $this->creerModeCotisation($manager, $epargne, $awa, false);
        $this->creerModeCotisation($manager, $epargne, $fatou, true);
        $this->creerModeCotisation($manager, $epargne, $mariama, false);

        // Séances
        $seanceTontine = (new Seance())
            ->setDate(new \DateTime('2026-11-01'))
            ->setCampagne($tontine);
        $manager->persist($seanceTontine);

        $seanceEpargne = (new Seance())
            ->setDate(new \DateTime('2026-11-01'))
            ->setCampagne($epargne);
        $manager->persist($seanceEpargne);

        // Cotisations de la tontine (montant imposé pour tout le monde)
        foreach ([$awa, $fatou, $mariama] as $membre) {
            $this->creerCotisation($manager, $membre, $seanceTontine, 10000);
        }

        // Cotisations de l'épargne (Fatou cotise librement, moins que le montant prévu)
        $this->creerCotisation($manager, $awa, $seanceEpargne, 5000);
        $this->creerCotisation($manager, $fatou, $seanceEpargne, 2000);
        $this->creerCotisation($manager, $mariama, $seanceEpargne, 5000);

        // Prêts : un remboursé, un non remboursé
        $pretRembourse = (new Pret())
            ->setMontant(20000)
            ->setDateDemande(new \DateTime('2026-09-06'))
            ->setDateRemboursement(new \DateTime('2026-10-04'))
            ->setMembre($fatou);
        $manager->persist($pretRembourse);

        $pretEnCours = (new Pret())
            ->setMontant(15000)
            ->setDateDemande(new \DateTime('2026-10-11'))
            ->setDateRemboursement(null)
            ->setMembre($mariama);
        $manager->persist($pretEnCours);

        $manager->flush();
    }

    private function creerMembre(
        ObjectManager $manager,
        string $nomComplet,
        string $telephone,
        string $addresse,
        string $login,
        Groupement $groupement,
        $role,
        Fonction $fonction
    ): Membre {
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

        return $membre;
    }

    private function creerModeCotisation(ObjectManager $manager, Epargne $epargne, Membre $membre, bool $isLibre): void
    {
        $mode = (new ModeCotisation())
            ->setIslibre($isLibre)
            ->setEpargne($epargne)
            ->setMembre($membre);
        $manager->persist($mode);
    }

    private function creerCotisation(ObjectManager $manager, Membre $membre, Seance $seance, float $montant): void
    {
        $cotisation = (new Cotisation())
            ->setMontant($montant)
            ->setDateCotisation(new \DateTime('2026-11-01'))
            ->setMembre($membre)
            ->setSeance($seance);
        $manager->persist($cotisation);
    }
}