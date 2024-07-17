<?php

declare(strict_types=1);

namespace Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240717073043 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE actvie_p6_free_status (id INT UNSIGNED AUTO_INCREMENT NOT NULL, status VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE active_p6_master_class_cohort ADD status_id INT UNSIGNED DEFAULT NULL');
        $this->addSql('ALTER TABLE active_p6_master_class_cohort ADD CONSTRAINT FK_A41EE76BF700BD FOREIGN KEY (status_id) REFERENCES actvie_p6_free_status (id)');
        $this->addSql('CREATE INDEX IDX_A41EE76BF700BD ON active_p6_master_class_cohort (status_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE active_p6_master_class_cohort DROP FOREIGN KEY FK_A41EE76BF700BD');
        $this->addSql('DROP TABLE actvie_p6_free_status');
        $this->addSql('DROP INDEX IDX_A41EE76BF700BD ON active_p6_master_class_cohort');
        $this->addSql('ALTER TABLE active_p6_master_class_cohort DROP status_id');
    }
}
