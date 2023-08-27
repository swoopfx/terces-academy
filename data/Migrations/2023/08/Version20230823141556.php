<?php

declare(strict_types=1);

namespace Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230823141556 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE course_resource (id INT UNSIGNED AUTO_INCREMENT NOT NULL, courses_id INT UNSIGNED DEFAULT NULL, uuid VARCHAR(255) NOT NULL, resourceTitle VARCHAR(255) NOT NULL, createdOn DATETIME NOT NULL, updatedOn DATETIME NOT NULL, resourceFile_id INT DEFAULT NULL, UNIQUE INDEX UNIQ_15259940D17F50A6 (uuid), INDEX IDX_15259940F9295384 (courses_id), INDEX IDX_152599406DB94D89 (resourceFile_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE course_resource ADD CONSTRAINT FK_15259940F9295384 FOREIGN KEY (courses_id) REFERENCES courses (id)');
        $this->addSql('ALTER TABLE course_resource ADD CONSTRAINT FK_152599406DB94D89 FOREIGN KEY (resourceFile_id) REFERENCES image (id)');
        $this->addSql('ALTER TABLE image CHANGE image_url image_url LONGTEXT DEFAULT NULL');
        $this->addSql('ALTER TABLE resourcess DROP resourceDesc');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE course_resource DROP FOREIGN KEY FK_15259940F9295384');
        $this->addSql('ALTER TABLE course_resource DROP FOREIGN KEY FK_152599406DB94D89');
        $this->addSql('DROP TABLE course_resource');
        $this->addSql('ALTER TABLE image CHANGE image_url image_url VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE resourcess ADD resourceDesc LONGTEXT DEFAULT NULL');
    }
}
