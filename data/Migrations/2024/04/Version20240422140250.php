<?php

declare(strict_types=1);

namespace Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240422140250 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE room_type (id INT AUTO_INCREMENT NOT NULL, type VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE active_p6_cohort ADD activeUserProgram_id INT UNSIGNED DEFAULT NULL');
        $this->addSql('ALTER TABLE active_p6_cohort ADD CONSTRAINT FK_F479372380F7D477 FOREIGN KEY (activeUserProgram_id) REFERENCES active_user_program (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_F479372380F7D477 ON active_p6_cohort (activeUserProgram_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE room_type');
        $this->addSql('ALTER TABLE active_p6_cohort DROP FOREIGN KEY FK_F479372380F7D477');
        $this->addSql('DROP INDEX UNIQ_F479372380F7D477 ON active_p6_cohort');
        $this->addSql('ALTER TABLE active_p6_cohort DROP activeUserProgram_id');
    }
}
