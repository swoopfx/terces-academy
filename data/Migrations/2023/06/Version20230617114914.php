<?php

declare(strict_types=1);

namespace Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230617114914 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE payment_method (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE resource_type (id INT AUTO_INCREMENT NOT NULL, type VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE resourcess (id INT AUTO_INCREMENT NOT NULL, uuid VARCHAR(255) NOT NULL, resourceTitle VARCHAR(255) NOT NULL, resourceDesc LONGTEXT DEFAULT NULL, createdOn DATETIME DEFAULT NULL, updatedOn DATETIME DEFAULT NULL, courseContent_id INT UNSIGNED DEFAULT NULL, resourcesType_id INT DEFAULT NULL, resourceFile_id INT DEFAULT NULL, INDEX IDX_2A8F270F4C0418C (courseContent_id), INDEX IDX_2A8F270FF98825FE (resourcesType_id), INDEX IDX_2A8F270F6DB94D89 (resourceFile_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE resourcess ADD CONSTRAINT FK_2A8F270F4C0418C FOREIGN KEY (courseContent_id) REFERENCES course_content (id)');
        $this->addSql('ALTER TABLE resourcess ADD CONSTRAINT FK_2A8F270FF98825FE FOREIGN KEY (resourcesType_id) REFERENCES resource_type (id)');
        $this->addSql('ALTER TABLE resourcess ADD CONSTRAINT FK_2A8F270F6DB94D89 FOREIGN KEY (resourceFile_id) REFERENCES image (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE resourcess DROP FOREIGN KEY FK_2A8F270F4C0418C');
        $this->addSql('ALTER TABLE resourcess DROP FOREIGN KEY FK_2A8F270FF98825FE');
        $this->addSql('ALTER TABLE resourcess DROP FOREIGN KEY FK_2A8F270F6DB94D89');
        $this->addSql('DROP TABLE payment_method');
        $this->addSql('DROP TABLE resource_type');
        $this->addSql('DROP TABLE resourcess');
    }
}
