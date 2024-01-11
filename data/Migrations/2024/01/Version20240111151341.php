<?php

declare(strict_types=1);

namespace Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240111151341 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE zoom_meeting_response (id INT AUTO_INCREMENT NOT NULL, type_id INT DEFAULT NULL, user_id INT DEFAULT NULL, zoomId VARCHAR(255) NOT NULL, zoomAssitantId VARCHAR(255) NOT NULL, zoomRegUrl VARCHAR(255) NOT NULL, zoomMeetingPassword VARCHAR(255) NOT NULL, createdOn DATETIME NOT NULL, updatedOn DATETIME NOT NULL, INDEX IDX_AD39E17C54C8C93 (type_id), INDEX IDX_AD39E17A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE zoom_meeting_type (id INT AUTO_INCREMENT NOT NULL, type VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE zoom_meeting_response ADD CONSTRAINT FK_AD39E17C54C8C93 FOREIGN KEY (type_id) REFERENCES zoom_meeting_type (id)');
        $this->addSql('ALTER TABLE zoom_meeting_response ADD CONSTRAINT FK_AD39E17A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE user CHANGE email email VARCHAR(200) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE zoom_meeting_response DROP FOREIGN KEY FK_AD39E17C54C8C93');
        $this->addSql('ALTER TABLE zoom_meeting_response DROP FOREIGN KEY FK_AD39E17A76ED395');
        $this->addSql('DROP TABLE zoom_meeting_response');
        $this->addSql('DROP TABLE zoom_meeting_type');
        $this->addSql('ALTER TABLE user CHANGE email email VARCHAR(30) NOT NULL');
    }
}
