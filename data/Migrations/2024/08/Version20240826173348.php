<?php

declare(strict_types=1);

namespace Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240826173348 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE active_zoom_class_id DROP FOREIGN KEY FK_CEBFDC1B985B27BF');
        $this->addSql('DROP INDEX IDX_CEBFDC1B985B27BF ON active_zoom_class_id');
        $this->addSql('ALTER TABLE active_zoom_class_id CHANGE classRoomId_id classRoomId INT DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE active_zoom_class_id CHANGE classRoomId classRoomId_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE active_zoom_class_id ADD CONSTRAINT FK_CEBFDC1B985B27BF FOREIGN KEY (classRoomId_id) REFERENCES oracle_classes (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_CEBFDC1B985B27BF ON active_zoom_class_id (classRoomId_id)');
    }
}
