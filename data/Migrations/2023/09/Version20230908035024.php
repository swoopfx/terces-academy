<?php

declare(strict_types=1);

namespace Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230908035024 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE active_user_program DROP FOREIGN KEY FK_2BBA0E634C55A862');
        $this->addSql('DROP INDEX IDX_2BBA0E634C55A862 ON active_user_program');
        $this->addSql('ALTER TABLE active_user_program DROP activeInstallment_id');
        $this->addSql('ALTER TABLE installment ADD amountPayable VARCHAR(255) NOT NULL, ADD activeUserProgram_id INT UNSIGNED DEFAULT NULL');
        $this->addSql('ALTER TABLE installment ADD CONSTRAINT FK_4B778ACD80F7D477 FOREIGN KEY (activeUserProgram_id) REFERENCES active_user_program (id)');
        $this->addSql('CREATE INDEX IDX_4B778ACD80F7D477 ON installment (activeUserProgram_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE active_user_program ADD activeInstallment_id INT UNSIGNED DEFAULT NULL');
        $this->addSql('ALTER TABLE active_user_program ADD CONSTRAINT FK_2BBA0E634C55A862 FOREIGN KEY (activeInstallment_id) REFERENCES installment (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_2BBA0E634C55A862 ON active_user_program (activeInstallment_id)');
        $this->addSql('ALTER TABLE installment DROP FOREIGN KEY FK_4B778ACD80F7D477');
        $this->addSql('DROP INDEX IDX_4B778ACD80F7D477 ON installment');
        $this->addSql('ALTER TABLE installment DROP amountPayable, DROP activeUserProgram_id');
    }
}
