<?php

declare(strict_types=1);

namespace Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230907144213 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE installment (id INT UNSIGNED AUTO_INCREMENT NOT NULL, uuid VARCHAR(255) NOT NULL, expirationDate DATETIME NOT NULL, isSettled TINYINT(1) DEFAULT 0 NOT NULL, createdOn DATETIME DEFAULT NULL, updatedOn DATETIME DEFAULT NULL, UNIQUE INDEX UNIQ_4B778ACDD17F50A6 (uuid), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE active_user_program ADD isInstallement TINYINT(1) DEFAULT 0 NOT NULL, ADD activeInstallment_id INT UNSIGNED DEFAULT NULL');
        $this->addSql('ALTER TABLE active_user_program ADD CONSTRAINT FK_2BBA0E634C55A862 FOREIGN KEY (activeInstallment_id) REFERENCES installment (id)');
        $this->addSql('CREATE INDEX IDX_2BBA0E634C55A862 ON active_user_program (activeInstallment_id)');
        $this->addSql('ALTER TABLE quiz_answer CHANGE answerText answerText LONGTEXT NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE active_user_program DROP FOREIGN KEY FK_2BBA0E634C55A862');
        $this->addSql('DROP TABLE installment');
        $this->addSql('DROP INDEX IDX_2BBA0E634C55A862 ON active_user_program');
        $this->addSql('ALTER TABLE active_user_program DROP isInstallement, DROP activeInstallment_id');
        $this->addSql('ALTER TABLE quiz_answer CHANGE answerText answerText VARCHAR(255) NOT NULL');
    }
}
