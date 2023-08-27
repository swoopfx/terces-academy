<?php

declare(strict_types=1);

namespace Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230823201410 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE quiz_answer (id INT AUTO_INCREMENT NOT NULL, question_id INT DEFAULT NULL, uuid VARCHAR(255) NOT NULL, answerText VARCHAR(255) NOT NULL, isAnswer TINYINT(1) DEFAULT 0 NOT NULL, createdOn DATETIME NOT NULL, updatedOn DATETIME NOT NULL, UNIQUE INDEX UNIQ_3799BA7CD17F50A6 (uuid), INDEX IDX_3799BA7C1E27F6BF (question_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE quiz_answer ADD CONSTRAINT FK_3799BA7C1E27F6BF FOREIGN KEY (question_id) REFERENCES quiz_question (id)');
        $this->addSql('DROP INDEX UNIQ_A412FA9234A2147A ON quiz');
        $this->addSql('ALTER TABLE quiz DROP quizId, DROP title');
        $this->addSql('ALTER TABLE quiz_question ADD quiz_id INT DEFAULT NULL, DROP type');
        $this->addSql('ALTER TABLE quiz_question ADD CONSTRAINT FK_6033B00B853CD175 FOREIGN KEY (quiz_id) REFERENCES quiz (id)');
        $this->addSql('CREATE INDEX IDX_6033B00B853CD175 ON quiz_question (quiz_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE quiz_answer DROP FOREIGN KEY FK_3799BA7C1E27F6BF');
        $this->addSql('DROP TABLE quiz_answer');
        $this->addSql('ALTER TABLE quiz ADD quizId VARCHAR(255) NOT NULL, ADD title LONGTEXT DEFAULT NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_A412FA9234A2147A ON quiz (quizId)');
        $this->addSql('ALTER TABLE quiz_question DROP FOREIGN KEY FK_6033B00B853CD175');
        $this->addSql('DROP INDEX IDX_6033B00B853CD175 ON quiz_question');
        $this->addSql('ALTER TABLE quiz_question ADD type VARCHAR(255) NOT NULL, DROP quiz_id');
    }
}
