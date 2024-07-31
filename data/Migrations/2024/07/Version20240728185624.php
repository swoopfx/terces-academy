<?php

declare(strict_types=1);

namespace Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240728185624 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE active_business_analysis_cohort (id INT UNSIGNED AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, cohort_id INT UNSIGNED DEFAULT NULL, status_id INT UNSIGNED DEFAULT NULL, program_id INT DEFAULT NULL, isActive TINYINT(1) DEFAULT 1 NOT NULL, createdOn DATETIME NOT NULL, updatedOn DATETIME NOT NULL, uuid VARCHAR(255) NOT NULL, isAll TINYINT(1) DEFAULT 0 NOT NULL, activeUserProgram_id INT UNSIGNED DEFAULT NULL, UNIQUE INDEX UNIQ_96ADDF6BD17F50A6 (uuid), INDEX IDX_96ADDF6BA76ED395 (user_id), INDEX IDX_96ADDF6B35983C93 (cohort_id), INDEX IDX_96ADDF6B6BF700BD (status_id), UNIQUE INDEX UNIQ_96ADDF6B80F7D477 (activeUserProgram_id), INDEX IDX_96ADDF6B3EB8070A (program_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE active_business_analysis_cohort ADD CONSTRAINT FK_96ADDF6BA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE active_business_analysis_cohort ADD CONSTRAINT FK_96ADDF6B35983C93 FOREIGN KEY (cohort_id) REFERENCES master_class_cohort (id)');
        $this->addSql('ALTER TABLE active_business_analysis_cohort ADD CONSTRAINT FK_96ADDF6B6BF700BD FOREIGN KEY (status_id) REFERENCES actvie_master_class_status (id)');
        $this->addSql('ALTER TABLE active_business_analysis_cohort ADD CONSTRAINT FK_96ADDF6B80F7D477 FOREIGN KEY (activeUserProgram_id) REFERENCES active_user_program (id)');
        $this->addSql('ALTER TABLE active_business_analysis_cohort ADD CONSTRAINT FK_96ADDF6B3EB8070A FOREIGN KEY (program_id) REFERENCES programss (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE active_business_analysis_cohort DROP FOREIGN KEY FK_96ADDF6BA76ED395');
        $this->addSql('ALTER TABLE active_business_analysis_cohort DROP FOREIGN KEY FK_96ADDF6B35983C93');
        $this->addSql('ALTER TABLE active_business_analysis_cohort DROP FOREIGN KEY FK_96ADDF6B6BF700BD');
        $this->addSql('ALTER TABLE active_business_analysis_cohort DROP FOREIGN KEY FK_96ADDF6B80F7D477');
        $this->addSql('ALTER TABLE active_business_analysis_cohort DROP FOREIGN KEY FK_96ADDF6B3EB8070A');
        $this->addSql('DROP TABLE active_business_analysis_cohort');
    }
}
