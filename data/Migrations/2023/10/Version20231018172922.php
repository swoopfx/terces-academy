<?php

declare(strict_types=1);

namespace Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231018172922 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE schedule_career_talk (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, datee DATE NOT NULL, timee VARCHAR(255) NOT NULL, searchString VARCHAR(255) NOT NULL, dateString VARCHAR(255) NOT NULL, createdOn DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, updatedOn DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, isPayment TINYINT(1) DEFAULT 0 NOT NULL, UNIQUE INDEX UNIQ_D90F1CE9271F98EA (searchString), INDEX IDX_D90F1CE9A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE schedule_career_talk ADD CONSTRAINT FK_D90F1CE9A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE schedule_career_talk DROP FOREIGN KEY FK_D90F1CE9A76ED395');
        $this->addSql('DROP TABLE schedule_career_talk');
    }
}
