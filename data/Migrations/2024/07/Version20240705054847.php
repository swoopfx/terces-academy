<?php

declare(strict_types=1);

namespace Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240705054847 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE zoom_meeting_response ADD program_id INT DEFAULT NULL, ADD uuid VARCHAR(255) NOT NULL, ADD zoomJoinUrl LONGTEXT NOT NULL, ADD zoomhostId VARCHAR(255) DEFAULT NULL, ADD zoomUuid VARCHAR(255) DEFAULT NULL, ADD zoomResponse LONGTEXT DEFAULT NULL, ADD zoomPassword VARCHAR(255) DEFAULT NULL, ADD zoomEncryptPassword VARCHAR(255) DEFAULT NULL, ADD freeBusinessMasterClassCohort_id INT UNSIGNED DEFAULT NULL, ADD freeOracleCohort_id INT UNSIGNED DEFAULT NULL, CHANGE zoomRegUrl zoomRegUrl LONGTEXT NOT NULL');
        $this->addSql('ALTER TABLE zoom_meeting_response ADD CONSTRAINT FK_AD39E173EB8070A FOREIGN KEY (program_id) REFERENCES programss (id)');
        $this->addSql('ALTER TABLE zoom_meeting_response ADD CONSTRAINT FK_AD39E17844384F4 FOREIGN KEY (freeBusinessMasterClassCohort_id) REFERENCES master_class_cohort (id)');
        $this->addSql('ALTER TABLE zoom_meeting_response ADD CONSTRAINT FK_AD39E1710C5FE6 FOREIGN KEY (freeOracleCohort_id) REFERENCES p6cohort (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_AD39E17D17F50A6 ON zoom_meeting_response (uuid)');
        $this->addSql('CREATE INDEX IDX_AD39E173EB8070A ON zoom_meeting_response (program_id)');
        $this->addSql('CREATE INDEX IDX_AD39E17844384F4 ON zoom_meeting_response (freeBusinessMasterClassCohort_id)');
        $this->addSql('CREATE INDEX IDX_AD39E1710C5FE6 ON zoom_meeting_response (freeOracleCohort_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE zoom_meeting_response DROP FOREIGN KEY FK_AD39E173EB8070A');
        $this->addSql('ALTER TABLE zoom_meeting_response DROP FOREIGN KEY FK_AD39E17844384F4');
        $this->addSql('ALTER TABLE zoom_meeting_response DROP FOREIGN KEY FK_AD39E1710C5FE6');
        $this->addSql('DROP INDEX UNIQ_AD39E17D17F50A6 ON zoom_meeting_response');
        $this->addSql('DROP INDEX IDX_AD39E173EB8070A ON zoom_meeting_response');
        $this->addSql('DROP INDEX IDX_AD39E17844384F4 ON zoom_meeting_response');
        $this->addSql('DROP INDEX IDX_AD39E1710C5FE6 ON zoom_meeting_response');
        $this->addSql('ALTER TABLE zoom_meeting_response DROP program_id, DROP uuid, DROP zoomJoinUrl, DROP zoomhostId, DROP zoomUuid, DROP zoomResponse, DROP zoomPassword, DROP zoomEncryptPassword, DROP freeBusinessMasterClassCohort_id, DROP freeOracleCohort_id, CHANGE zoomRegUrl zoomRegUrl VARCHAR(255) NOT NULL');
    }
}
