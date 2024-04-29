<?php

declare(strict_types=1);

namespace Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240425141941 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE active_p6_cohort DROP FOREIGN KEY FK_F47937236BF700BD');
        $this->addSql('ALTER TABLE active_p6_cohort ADD CONSTRAINT FK_F47937236BF700BD FOREIGN KEY (status_id) REFERENCES active_p6_cohort_status (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE active_p6_cohort DROP FOREIGN KEY FK_F47937236BF700BD');
        $this->addSql('ALTER TABLE active_p6_cohort ADD CONSTRAINT FK_F47937236BF700BD FOREIGN KEY (status_id) REFERENCES active_user_program_status (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
    }
}
