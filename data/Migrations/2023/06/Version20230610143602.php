<?php

declare(strict_types=1);

namespace Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230610143602 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE pr_events (id INT AUTO_INCREMENT NOT NULL, eventname VARCHAR(255) NOT NULL, eventDescription LONGTEXT DEFAULT NULL, dateTimeBegin DATETIME DEFAULT NULL, dateTimeEnd DATETIME DEFAULT NULL, isActive TINYINT(1) DEFAULT NULL, createdOn DATETIME DEFAULT NULL, updatedOn DATETIME DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE courses ADD video_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE courses ADD CONSTRAINT FK_A9A55A4C29C1004E FOREIGN KEY (video_id) REFERENCES image (id)');
        $this->addSql('CREATE INDEX IDX_A9A55A4C29C1004E ON courses (video_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE pr_events');
        $this->addSql('ALTER TABLE courses DROP FOREIGN KEY FK_A9A55A4C29C1004E');
        $this->addSql('DROP INDEX IDX_A9A55A4C29C1004E ON courses');
        $this->addSql('ALTER TABLE courses DROP video_id');
    }
}
