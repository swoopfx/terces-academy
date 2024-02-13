<?php

declare(strict_types=1);

namespace Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230925114128 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE interac_payment ADD program_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE interac_payment ADD CONSTRAINT FK_EFA205CC3EB8070A FOREIGN KEY (program_id) REFERENCES programss (id)');
        $this->addSql('CREATE INDEX IDX_EFA205CC3EB8070A ON interac_payment (program_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE interac_payment DROP FOREIGN KEY FK_EFA205CC3EB8070A');
        $this->addSql('DROP INDEX IDX_EFA205CC3EB8070A ON interac_payment');
        $this->addSql('ALTER TABLE interac_payment DROP program_id');
    }
}
