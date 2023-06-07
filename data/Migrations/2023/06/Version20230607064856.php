<?php

declare(strict_types=1);

namespace Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230607064856 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE course_content (id INT UNSIGNED AUTO_INCREMENT NOT NULL, banner_id INT DEFAULT NULL, courses_id INT UNSIGNED DEFAULT NULL, uuid VARCHAR(255) NOT NULL, title VARCHAR(255) DEFAULT NULL, course_video VARCHAR(255) DEFAULT NULL, is_active TINYINT(1) DEFAULT NULL, created_on DATETIME DEFAULT NULL, updated_on DATETIME DEFAULT NULL, INDEX IDX_F6063545684EC833 (banner_id), INDEX IDX_F6063545F9295384 (courses_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE courses (id INT UNSIGNED AUTO_INCREMENT NOT NULL, programs_id INT DEFAULT NULL, banner_id INT DEFAULT NULL, uuid VARCHAR(255) NOT NULL, title VARCHAR(255) NOT NULL, description LONGTEXT DEFAULT NULL, createdOn DATETIME NOT NULL, updatedOn DATETIME NOT NULL, INDEX IDX_A9A55A4C79AEC3C (programs_id), INDEX IDX_A9A55A4C684EC833 (banner_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE image (id INT AUTO_INCREMENT NOT NULL, image_uid VARCHAR(255) DEFAULT NULL, image_url VARCHAR(255) DEFAULT NULL, low_resolution VARCHAR(255) DEFAULT NULL, thumbnail VARCHAR(255) DEFAULT NULL, image_name VARCHAR(200) DEFAULT NULL, is_hidden TINYINT(1) DEFAULT NULL, mime_type VARCHAR(100) DEFAULT NULL, image_ext VARCHAR(45) DEFAULT NULL, created_on DATETIME DEFAULT NULL, updated_on DATETIME DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE programss (id INT AUTO_INCREMENT NOT NULL, uuid VARCHAR(255) NOT NULL, programId VARCHAR(255) DEFAULT NULL, cost VARCHAR(255) DEFAULT NULL, title VARCHAR(255) DEFAULT NULL, duration VARCHAR(255) DEFAULT NULL, description LONGTEXT DEFAULT NULL, createdOn DATETIME NOT NULL, updatedon DATETIME NOT NULL, isActive TINYINT(1) DEFAULT 1, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE course_content ADD CONSTRAINT FK_F6063545684EC833 FOREIGN KEY (banner_id) REFERENCES image (id)');
        $this->addSql('ALTER TABLE course_content ADD CONSTRAINT FK_F6063545F9295384 FOREIGN KEY (courses_id) REFERENCES courses (id)');
        $this->addSql('ALTER TABLE courses ADD CONSTRAINT FK_A9A55A4C79AEC3C FOREIGN KEY (programs_id) REFERENCES programss (id)');
        $this->addSql('ALTER TABLE courses ADD CONSTRAINT FK_A9A55A4C684EC833 FOREIGN KEY (banner_id) REFERENCES image (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE course_content DROP FOREIGN KEY FK_F6063545684EC833');
        $this->addSql('ALTER TABLE course_content DROP FOREIGN KEY FK_F6063545F9295384');
        $this->addSql('ALTER TABLE courses DROP FOREIGN KEY FK_A9A55A4C79AEC3C');
        $this->addSql('ALTER TABLE courses DROP FOREIGN KEY FK_A9A55A4C684EC833');
        $this->addSql('DROP TABLE course_content');
        $this->addSql('DROP TABLE courses');
        $this->addSql('DROP TABLE image');
        $this->addSql('DROP TABLE programss');
    }
}
