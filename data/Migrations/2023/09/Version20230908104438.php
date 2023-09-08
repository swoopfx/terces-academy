<?php

declare(strict_types=1);

namespace Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230908104438 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE installment DROP FOREIGN KEY FK_4B778ACD80F7D477');
        $this->addSql('DROP INDEX IDX_4B778ACD80F7D477 ON installment');
        $this->addSql('ALTER TABLE installment ADD user_id INT DEFAULT NULL, ADD program_id INT DEFAULT NULL, DROP activeUserProgram_id');
        $this->addSql('ALTER TABLE installment ADD CONSTRAINT FK_4B778ACDA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE installment ADD CONSTRAINT FK_4B778ACD3EB8070A FOREIGN KEY (program_id) REFERENCES programss (id)');
        $this->addSql('CREATE INDEX IDX_4B778ACDA76ED395 ON installment (user_id)');
        $this->addSql('CREATE INDEX IDX_4B778ACD3EB8070A ON installment (program_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE installment DROP FOREIGN KEY FK_4B778ACDA76ED395');
        $this->addSql('ALTER TABLE installment DROP FOREIGN KEY FK_4B778ACD3EB8070A');
        $this->addSql('DROP INDEX IDX_4B778ACDA76ED395 ON installment');
        $this->addSql('DROP INDEX IDX_4B778ACD3EB8070A ON installment');
        $this->addSql('ALTER TABLE installment ADD activeUserProgram_id INT UNSIGNED DEFAULT NULL, DROP user_id, DROP program_id');
        $this->addSql('ALTER TABLE installment ADD CONSTRAINT FK_4B778ACD80F7D477 FOREIGN KEY (activeUserProgram_id) REFERENCES active_user_program (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_4B778ACD80F7D477 ON installment (activeUserProgram_id)');
    }
}
