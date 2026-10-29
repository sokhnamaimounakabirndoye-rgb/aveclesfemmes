<?php

namespace App\DataFixtures;

use App\Entity\EpargneCalebasse;
use App\Entity\EpargneDureePrecise;
use App\Entity\Exercice;
use App\Entity\Groupement;
use App\Entity\Membre;
use App\Entity\Periodicite;
use App\Entity\Tontine;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class CampagneFixtures extends Fixture implements DependentFixtureInterface
{
    public const TONTINE = 'campagne_tontine';
    public const CALEBASSE = 'campagne_calebasse';
    public const DUREE_PRECISE = 'campagne_duree_precise';

    public function load(ObjectManager $manager): void
    {
        $groupement = $this->getReference(GroupementFixtures::GROUPEMENT_SOKHNA, Groupement::class);
        $exercice = $this->getReference(ExerciceFixtures::EN_COURS, Exercice::class);

        $hebdomadaire = $this->getReference(PeriodiciteFixtures::HEBDOMADAIRE, Periodicite::class);
        $mensuelle = $this->getReference(PeriodiciteFixtures::MENSUELLE, Periodicite::class);
        $quinzaine = $this->getReference(PeriodiciteFixtures::QUINZAINE, Periodicite::class);

        // Le jour de la périodicité est le jour de début de la campagne
        $tontine = (new Tontine())
            ->setNom('Tontine mensuelle')
            ->setDateDebut(new \DateTime('2026-10-04'))
            ->setDateFin(new \DateTime('2027-10-03'))
            ->setMontant(10000)
            ->setDelaiCotisation(3)
            ->setCaissePresent(500)
            ->setCaisseAbsent(1000)
            ->setAmendeJournaliere(200)
            ->setGroupement($groupement)
            ->setExercice($exercice)
            ->setPeriodiciteCotisation($mensuelle)
            ->setPeriodiciteRencontre($mensuelle);
        $manager->persist($tontine);

        // Épargne calebasse : toute la durée de l'exercice, participation obligatoire
        $calebasse = (new EpargneCalebasse())
            ->setNom('Épargne calebasse')
            ->setDateDebut(new \DateTime('2026-10-04'))
            ->setDateFin(new \DateTime('2027-10-03'))
            ->setMontant(5000)
            ->setDelaiCotisation(2)
            ->setCaissePresent(200)
            ->setCaisseAbsent(400)
            ->setAmendeJournaliere(100)
            ->setGroupement($groupement)
            ->setExercice($exercice)
            ->setPeriodiciteCotisation($hebdomadaire)
            ->setPeriodiciteRencontre($hebdomadaire);
        $manager->persist($calebasse);

        // Épargne à durée précise : participation optionnelle
        $dureePrecise = (new EpargneDureePrecise())
            ->setNom('Épargne scolaire (3 mois)')
            ->setDateDebut(new \DateTime('2026-10-11'))
            ->setDateFin(new \DateTime('2027-01-10'))
            ->setMontant(3000)
            ->setDelaiCotisation(2)
            ->setCaissePresent(100)
            ->setCaisseAbsent(200)
            ->setAmendeJournaliere(50)
            ->setGroupement($groupement)
            ->setExercice($exercice)
            ->setPeriodiciteCotisation($quinzaine)
            ->setPeriodiciteRencontre($quinzaine);
        $manager->persist($dureePrecise);

        // Participation des membres (le SupAdmin ne participe à aucune campagne)
        $awa = $this->getReference(MembreFixtures::AWA, Membre::class);
        $fatou = $this->getReference(MembreFixtures::FATOU, Membre::class);
        $mariama = $this->getReference(MembreFixtures::MARIAMA, Membre::class);
        $khady = $this->getReference(MembreFixtures::KHADY, Membre::class);

        foreach ([$awa, $fatou, $mariama, $khady] as $membre) {
            $membre->addCampagne($tontine);
            $membre->addCampagne($calebasse);
        }

        foreach ([$fatou, $mariama] as $membre) {
            $membre->addCampagne($dureePrecise);
        }

        $manager->flush();

        $this->addReference(self::TONTINE, $tontine);
        $this->addReference(self::CALEBASSE, $calebasse);
        $this->addReference(self::DUREE_PRECISE, $dureePrecise);
    }

    public function getDependencies(): array
    {
        return [
            GroupementFixtures::class,
            ExerciceFixtures::class,
            PeriodiciteFixtures::class,
            MembreFixtures::class,
        ];
    }
}