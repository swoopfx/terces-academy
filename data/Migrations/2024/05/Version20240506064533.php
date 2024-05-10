<?php

declare(strict_types=1);

namespace Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240506064533 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE zoom_video ADD admin_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE zoom_video ADD CONSTRAINT FK_25AC3B73642B8210 FOREIGN KEY (admin_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_25AC3B73642B8210 ON zoom_video (admin_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE zoom_video DROP FOREIGN KEY FK_25AC3B73642B8210');
        $this->addSql('DROP INDEX IDX_25AC3B73642B8210 ON zoom_video');
        $this->addSql('ALTER TABLE zoom_video DROP admin_id');
    }
}
