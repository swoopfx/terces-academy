<?php

declare(strict_types=1);

namespace Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240709055013 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE p6_free_cohort (id INT UNSIGNED AUTO_INCREMENT NOT NULL, cohort VARCHAR(255) DEFAULT NULL, isActive TINYINT(1) DEFAULT 1 NOT NULL, uuid VARCHAR(255) DEFAULT NULL, startDate DATE NOT NULL, UNIQUE INDEX UNIQ_A162A771D17F50A6 (uuid), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE zoom_meeting_response DROP FOREIGN KEY FK_AD39E1710C5FE6');
        $this->addSql('ALTER TABLE zoom_meeting_response ADD zoomTitle VARCHAR(255) NOT NULL, ADD zoomStartTime VARCHAR(255) NOT NULL, ADD zoomDuration VARCHAR(255) NOT NULL, ADD zoomTimeZone VARCHAR(255) DEFAULT \'UTC\' NOT NULL, ADD businessAnalysisCohort_id INT DEFAULT NULL, ADD oracleP6Cohort_id INT UNSIGNED DEFAULT NULL, CHANGE zoomAssitantId zoomAssitantId VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE zoom_meeting_response ADD CONSTRAINT FK_AD39E177A08420A FOREIGN KEY (businessAnalysisCohort_id) REFERENCES internship_cohort (id)');
        $this->addSql('ALTER TABLE zoom_meeting_response ADD CONSTRAINT FK_AD39E1747BCCA9D FOREIGN KEY (oracleP6Cohort_id) REFERENCES p6cohort (id)');
        $this->addSql('ALTER TABLE zoom_meeting_response ADD CONSTRAINT FK_AD39E1710C5FE6 FOREIGN KEY (freeOracleCohort_id) REFERENCES p6_free_cohort (id)');
        $this->addSql('CREATE INDEX IDX_AD39E177A08420A ON zoom_meeting_response (businessAnalysisCohort_id)');
        $this->addSql('CREATE INDEX IDX_AD39E1747BCCA9D ON zoom_meeting_response (oracleP6Cohort_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE zoom_meeting_response DROP FOREIGN KEY FK_AD39E1710C5FE6');
        $this->addSql('DROP TABLE p6_free_cohort');
        $this->addSql('ALTER TABLE zoom_meeting_response DROP FOREIGN KEY FK_AD39E177A08420A');
        $this->addSql('ALTER TABLE zoom_meeting_response DROP FOREIGN KEY FK_AD39E1747BCCA9D');
        $this->addSql('ALTER TABLE zoom_meeting_response DROP FOREIGN KEY FK_AD39E1710C5FE6');
        $this->addSql('DROP INDEX IDX_AD39E177A08420A ON zoom_meeting_response');
        $this->addSql('DROP INDEX IDX_AD39E1747BCCA9D ON zoom_meeting_response');
        $this->addSql('ALTER TABLE zoom_meeting_response DROP zoomTitle, DROP zoomStartTime, DROP zoomDuration, DROP zoomTimeZone, DROP businessAnalysisCohort_id, DROP oracleP6Cohort_id, CHANGE zoomAssitantId zoomAssitantId VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE zoom_meeting_response ADD CONSTRAINT FK_AD39E1710C5FE6 FOREIGN KEY (freeOracleCohort_id) REFERENCES p6cohort (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
    }
}
