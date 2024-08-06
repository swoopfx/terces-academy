<?php

declare(strict_types=1);

namespace Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240803085130 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE p6_payment_tracker (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, cohort_id INT UNSIGNED DEFAULT NULL, transaction_id INT DEFAULT NULL, amount VARCHAR(255) NOT NULL, createdOn DATETIME NOT NULL, updatedOn DATETIME NOT NULL, userProgram_id INT UNSIGNED DEFAULT NULL, INDEX IDX_14FFCF76A76ED395 (user_id), INDEX IDX_14FFCF7635983C93 (cohort_id), INDEX IDX_14FFCF763C992823 (userProgram_id), INDEX IDX_14FFCF762FC0CB0F (transaction_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE p6_payment_tracker ADD CONSTRAINT FK_14FFCF76A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE p6_payment_tracker ADD CONSTRAINT FK_14FFCF7635983C93 FOREIGN KEY (cohort_id) REFERENCES p6cohort (id)');
        $this->addSql('ALTER TABLE p6_payment_tracker ADD CONSTRAINT FK_14FFCF763C992823 FOREIGN KEY (userProgram_id) REFERENCES active_user_program (id)');
        $this->addSql('ALTER TABLE p6_payment_tracker ADD CONSTRAINT FK_14FFCF762FC0CB0F FOREIGN KEY (transaction_id) REFERENCES transaction (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE p6_payment_tracker DROP FOREIGN KEY FK_14FFCF76A76ED395');
        $this->addSql('ALTER TABLE p6_payment_tracker DROP FOREIGN KEY FK_14FFCF7635983C93');
        $this->addSql('ALTER TABLE p6_payment_tracker DROP FOREIGN KEY FK_14FFCF763C992823');
        $this->addSql('ALTER TABLE p6_payment_tracker DROP FOREIGN KEY FK_14FFCF762FC0CB0F');
        $this->addSql('DROP TABLE p6_payment_tracker');
    }
}
