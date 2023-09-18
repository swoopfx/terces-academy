<?php

declare(strict_types=1);

namespace Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230908151619 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE installment ADD activeUserProgram_id INT UNSIGNED DEFAULT NULL');
        $this->addSql('ALTER TABLE installment ADD CONSTRAINT FK_4B778ACD80F7D477 FOREIGN KEY (activeUserProgram_id) REFERENCES active_user_program (id)');
        $this->addSql('CREATE INDEX IDX_4B778ACD80F7D477 ON installment (activeUserProgram_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE installment DROP FOREIGN KEY FK_4B778ACD80F7D477');
        $this->addSql('DROP INDEX IDX_4B778ACD80F7D477 ON installment');
        $this->addSql('ALTER TABLE installment DROP activeUserProgram_id');
    }
}
