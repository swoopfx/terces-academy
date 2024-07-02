<?php

declare(strict_types=1);

namespace Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240628110653 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE active_business_class_cohort (id INT UNSIGNED AUTO_INCREMENT NOT NULL, cohort_id INT UNSIGNED DEFAULT NULL, isActive TINYINT(1) DEFAULT 1 NOT NULL, createdOn DATETIME NOT NULL, updatedOn DATETIME NOT NULL, uuid VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_14261FA0D17F50A6 (uuid), INDEX IDX_14261FA035983C93 (cohort_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE actvie_master_class_status (id INT UNSIGNED AUTO_INCREMENT NOT NULL, status VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE master_class_cohort (id INT UNSIGNED AUTO_INCREMENT NOT NULL, cohortName VARCHAR(255) NOT NULL, startDate DATETIME NOT NULL, uuid VARCHAR(255) NOT NULL, createdOn DATETIME NOT NULL, isActive TINYINT(1) NOT NULL, UNIQUE INDEX UNIQ_813CFCCCD17F50A6 (uuid), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE active_business_class_cohort ADD CONSTRAINT FK_14261FA035983C93 FOREIGN KEY (cohort_id) REFERENCES certification_cohort (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE active_business_class_cohort DROP FOREIGN KEY FK_14261FA035983C93');
        $this->addSql('DROP TABLE active_business_class_cohort');
        $this->addSql('DROP TABLE actvie_master_class_status');
        $this->addSql('DROP TABLE master_class_cohort');
    }
}
