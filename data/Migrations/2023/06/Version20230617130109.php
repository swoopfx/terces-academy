<?php

declare(strict_types=1);

namespace Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230617130109 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE payment_method DROP FOREIGN KEY FK_7B61A1F63DA5256D');
        $this->addSql('DROP INDEX IDX_7B61A1F63DA5256D ON payment_method');
        $this->addSql('ALTER TABLE payment_method ADD image VARCHAR(255) NOT NULL, DROP image_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE payment_method ADD image_id INT DEFAULT NULL, DROP image');
        $this->addSql('ALTER TABLE payment_method ADD CONSTRAINT FK_7B61A1F63DA5256D FOREIGN KEY (image_id) REFERENCES image (id)');
        $this->addSql('CREATE INDEX IDX_7B61A1F63DA5256D ON payment_method (image_id)');
    }
}
