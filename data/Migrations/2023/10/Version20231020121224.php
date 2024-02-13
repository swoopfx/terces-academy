<?php

declare(strict_types=1);

namespace Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231020121224 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE internship_register ADD user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE internship_register ADD CONSTRAINT FK_4F992AADA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_4F992AADA76ED395 ON internship_register (user_id)');
        $this->addSql('ALTER TABLE transaction ADD servicee LONGTEXT DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE internship_register DROP FOREIGN KEY FK_4F992AADA76ED395');
        $this->addSql('DROP INDEX IDX_4F992AADA76ED395 ON internship_register');
        $this->addSql('ALTER TABLE internship_register DROP user_id');
        $this->addSql('ALTER TABLE transaction DROP servicee');
    }
}
