<?php

declare(strict_types=1);

namespace Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230810142520 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE quiz (id INT AUTO_INCREMENT NOT NULL, course_id INT UNSIGNED DEFAULT NULL, uuid VARCHAR(255) NOT NULL, quizId VARCHAR(255) NOT NULL, title LONGTEXT DEFAULT NULL, createdOn DATETIME NOT NULL, updatedOn DATETIME NOT NULL, UNIQUE INDEX UNIQ_A412FA92D17F50A6 (uuid), UNIQUE INDEX UNIQ_A412FA9234A2147A (quizId), INDEX IDX_A412FA92591CC992 (course_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE quiz_question (id INT AUTO_INCREMENT NOT NULL, uuid VARCHAR(255) NOT NULL, type VARCHAR(255) NOT NULL, question LONGTEXT NOT NULL, createdOn DATETIME NOT NULL, updatedOn DATETIME NOT NULL, isActive TINYINT(1) DEFAULT 1 NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE quiz ADD CONSTRAINT FK_A412FA92591CC992 FOREIGN KEY (course_id) REFERENCES courses (id)');
        $this->addSql('ALTER TABLE active_user_program ADD uuid VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE transaction ADD paypalId VARCHAR(255) DEFAULT NULL, ADD paypalOrderId VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE quiz DROP FOREIGN KEY FK_A412FA92591CC992');
        $this->addSql('DROP TABLE quiz');
        $this->addSql('DROP TABLE quiz_question');
        $this->addSql('ALTER TABLE active_user_program DROP uuid');
        $this->addSql('ALTER TABLE transaction DROP paypalId, DROP paypalOrderId');
    }
}
