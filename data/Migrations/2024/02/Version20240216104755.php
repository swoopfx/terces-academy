<?php

declare(strict_types=1);

namespace Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240216104755 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE internship_cohort ADD presentlyActive TINYINT(1) DEFAULT 0 NOT NULL');
        $this->addSql('ALTER TABLE zoom_video ADD cohort_id INT DEFAULT NULL, ADD video_id INT DEFAULT NULL, ADD isActive TINYINT(1) DEFAULT 1 NOT NULL, ADD uuid VARCHAR(255) NOT NULL, ADD createdOn DATETIME NOT NULL, ADD updatedOn DATETIME NOT NULL, CHANGE title titles VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE zoom_video ADD CONSTRAINT FK_25AC3B7335983C93 FOREIGN KEY (cohort_id) REFERENCES internship_cohort (id)');
        $this->addSql('ALTER TABLE zoom_video ADD CONSTRAINT FK_25AC3B7329C1004E FOREIGN KEY (video_id) REFERENCES image (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_25AC3B73D17F50A6 ON zoom_video (uuid)');
        $this->addSql('CREATE INDEX IDX_25AC3B7335983C93 ON zoom_video (cohort_id)');
        $this->addSql('CREATE INDEX IDX_25AC3B7329C1004E ON zoom_video (video_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE internship_cohort DROP presentlyActive');
        $this->addSql('ALTER TABLE zoom_video DROP FOREIGN KEY FK_25AC3B7335983C93');
        $this->addSql('ALTER TABLE zoom_video DROP FOREIGN KEY FK_25AC3B7329C1004E');
        $this->addSql('DROP INDEX UNIQ_25AC3B73D17F50A6 ON zoom_video');
        $this->addSql('DROP INDEX IDX_25AC3B7335983C93 ON zoom_video');
        $this->addSql('DROP INDEX IDX_25AC3B7329C1004E ON zoom_video');
        $this->addSql('ALTER TABLE zoom_video ADD title VARCHAR(255) NOT NULL, DROP cohort_id, DROP video_id, DROP titles, DROP isActive, DROP uuid, DROP createdOn, DROP updatedOn');
    }
}
