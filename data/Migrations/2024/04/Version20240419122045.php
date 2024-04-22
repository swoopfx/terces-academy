<?php

declare(strict_types=1);

namespace Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240419122045 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE active_p6_cohort (id INT UNSIGNED AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, status_id INT UNSIGNED DEFAULT NULL, isActive TINYINT(1) DEFAULT 1 NOT NULL, createdOn DATETIME NOT NULL, updatedOn DATETIME NOT NULL, uuid VARCHAR(255) NOT NULL, p6Cohort_id INT UNSIGNED DEFAULT NULL, UNIQUE INDEX UNIQ_F4793723D17F50A6 (uuid), INDEX IDX_F4793723A128BBFE (p6Cohort_id), INDEX IDX_F4793723A76ED395 (user_id), INDEX IDX_F47937236BF700BD (status_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE p6cohort (id INT UNSIGNED AUTO_INCREMENT NOT NULL, cohort VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE active_p6_cohort ADD CONSTRAINT FK_F4793723A128BBFE FOREIGN KEY (p6Cohort_id) REFERENCES p6cohort (id)');
        $this->addSql('ALTER TABLE active_p6_cohort ADD CONSTRAINT FK_F4793723A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE active_p6_cohort ADD CONSTRAINT FK_F47937236BF700BD FOREIGN KEY (status_id) REFERENCES active_user_program_status (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE active_p6_cohort DROP FOREIGN KEY FK_F4793723A128BBFE');
        $this->addSql('ALTER TABLE active_p6_cohort DROP FOREIGN KEY FK_F4793723A76ED395');
        $this->addSql('ALTER TABLE active_p6_cohort DROP FOREIGN KEY FK_F47937236BF700BD');
        $this->addSql('DROP TABLE active_p6_cohort');
        $this->addSql('DROP TABLE p6cohort');
    }
}
