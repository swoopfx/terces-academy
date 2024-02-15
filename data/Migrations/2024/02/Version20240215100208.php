<?php

declare(strict_types=1);

namespace Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240215100208 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE zoom_video (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, descs LONGTEXT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE user CHANGE password password VARCHAR(200) DEFAULT NULL, CHANGE registration_token registration_token VARCHAR(100) DEFAULT NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D649D09D01D3 ON user (registration_token)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE zoom_video');
        $this->addSql('DROP INDEX UNIQ_8D93D649D09D01D3 ON user');
        $this->addSql('ALTER TABLE user CHANGE password password VARCHAR(100) NOT NULL, CHANGE registration_token registration_token VARCHAR(32) DEFAULT NULL');
    }
}
