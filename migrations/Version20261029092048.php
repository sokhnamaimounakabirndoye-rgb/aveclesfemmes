<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20261029092048 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE campagne ADD caisse_present DOUBLE PRECISION NOT NULL');
        $this->addSql('ALTER TABLE campagne ADD caisse_absent DOUBLE PRECISION NOT NULL');
        $this->addSql('ALTER TABLE campagne ADD updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL');
        $this->addSql('ALTER TABLE campagne DROP update_at');
        $this->addSql('ALTER TABLE campagne DROP montant_der');
        $this->addSql('ALTER TABLE campagne DROP majoration_der');
        $this->addSql('ALTER TABLE cotisation ADD montant_caisse DOUBLE PRECISION NOT NULL');
        $this->addSql('ALTER TABLE cotisation ADD montant_amende DOUBLE PRECISION NOT NULL');
        $this->addSql('ALTER TABLE cotisation ADD created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL');
        $this->addSql('ALTER TABLE cotisation ADD updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL');
        $this->addSql('ALTER TABLE exercice ADD created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL');
        $this->addSql('ALTER TABLE exercice ADD updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL');
        $this->addSql('ALTER TABLE fonction ADD created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL');
        $this->addSql('ALTER TABLE fonction ADD updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL');
        $this->addSql('ALTER TABLE groupement ADD created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL');
        $this->addSql('ALTER TABLE groupement ADD updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL');
        $this->addSql('ALTER TABLE membre ADD created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL');
        $this->addSql('ALTER TABLE membre ADD updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL');
        $this->addSql('ALTER TABLE mode_cotisation ADD created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL');
        $this->addSql('ALTER TABLE mode_cotisation ADD updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL');
        $this->addSql('ALTER TABLE periodicite ADD created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL');
        $this->addSql('ALTER TABLE periodicite ADD updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL');
        $this->addSql('ALTER TABLE pret ADD created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL');
        $this->addSql('ALTER TABLE pret ADD updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL');
        $this->addSql('ALTER TABLE role ADD created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL');
        $this->addSql('ALTER TABLE role ADD updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL');
        $this->addSql('ALTER TABLE seance ADD created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL');
        $this->addSql('ALTER TABLE seance ADD updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE campagne ADD update_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL');
        $this->addSql('ALTER TABLE campagne ADD montant_der DOUBLE PRECISION NOT NULL');
        $this->addSql('ALTER TABLE campagne ADD majoration_der DOUBLE PRECISION NOT NULL');
        $this->addSql('ALTER TABLE campagne DROP caisse_present');
        $this->addSql('ALTER TABLE campagne DROP caisse_absent');
        $this->addSql('ALTER TABLE campagne DROP updated_at');
        $this->addSql('ALTER TABLE cotisation DROP montant_caisse');
        $this->addSql('ALTER TABLE cotisation DROP montant_amende');
        $this->addSql('ALTER TABLE cotisation DROP created_at');
        $this->addSql('ALTER TABLE cotisation DROP updated_at');
        $this->addSql('ALTER TABLE exercice DROP created_at');
        $this->addSql('ALTER TABLE exercice DROP updated_at');
        $this->addSql('ALTER TABLE fonction DROP created_at');
        $this->addSql('ALTER TABLE fonction DROP updated_at');
        $this->addSql('ALTER TABLE groupement DROP created_at');
        $this->addSql('ALTER TABLE groupement DROP updated_at');
        $this->addSql('ALTER TABLE membre DROP created_at');
        $this->addSql('ALTER TABLE membre DROP updated_at');
        $this->addSql('ALTER TABLE mode_cotisation DROP created_at');
        $this->addSql('ALTER TABLE mode_cotisation DROP updated_at');
        $this->addSql('ALTER TABLE periodicite DROP created_at');
        $this->addSql('ALTER TABLE periodicite DROP updated_at');
        $this->addSql('ALTER TABLE pret DROP created_at');
        $this->addSql('ALTER TABLE pret DROP updated_at');
        $this->addSql('ALTER TABLE role DROP created_at');
        $this->addSql('ALTER TABLE role DROP updated_at');
        $this->addSql('ALTER TABLE seance DROP created_at');
        $this->addSql('ALTER TABLE seance DROP updated_at');
    }
}
