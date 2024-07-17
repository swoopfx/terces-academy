<?php

declare(strict_types=1);

namespace Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240717072128 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE active_p6_master_class_cohort (id INT UNSIGNED AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, cohort_id INT UNSIGNED DEFAULT NULL, program_id INT DEFAULT NULL, isActive TINYINT(1) DEFAULT 1 NOT NULL, createdOn DATETIME NOT NULL, updatedOn DATETIME NOT NULL, uuid VARCHAR(255) NOT NULL, isAll TINYINT(1) DEFAULT 0 NOT NULL, activeUserProgram_id INT UNSIGNED DEFAULT NULL, UNIQUE INDEX UNIQ_A41EE7D17F50A6 (uuid), INDEX IDX_A41EE7A76ED395 (user_id), INDEX IDX_A41EE735983C93 (cohort_id), UNIQUE INDEX UNIQ_A41EE780F7D477 (activeUserProgram_id), INDEX IDX_A41EE73EB8070A (program_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE active_p6_master_class_cohort ADD CONSTRAINT FK_A41EE7A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE active_p6_master_class_cohort ADD CONSTRAINT FK_A41EE735983C93 FOREIGN KEY (cohort_id) REFERENCES p6_free_cohort (id)');
        $this->addSql('ALTER TABLE active_p6_master_class_cohort ADD CONSTRAINT FK_A41EE780F7D477 FOREIGN KEY (activeUserProgram_id) REFERENCES active_user_program (id)');
        $this->addSql('ALTER TABLE active_p6_master_class_cohort ADD CONSTRAINT FK_A41EE73EB8070A FOREIGN KEY (program_id) REFERENCES programss (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE active_p6_master_class_cohort DROP FOREIGN KEY FK_A41EE7A76ED395');
        $this->addSql('ALTER TABLE active_p6_master_class_cohort DROP FOREIGN KEY FK_A41EE735983C93');
        $this->addSql('ALTER TABLE active_p6_master_class_cohort DROP FOREIGN KEY FK_A41EE780F7D477');
        $this->addSql('ALTER TABLE active_p6_master_class_cohort DROP FOREIGN KEY FK_A41EE73EB8070A');
        $this->addSql('DROP TABLE active_p6_master_class_cohort');
    }
}
