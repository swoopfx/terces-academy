<?php

declare(strict_types=1);

namespace Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231220172729 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE projects (id INT AUTO_INCREMENT NOT NULL, cohort_id INT DEFAULT NULL, uuid VARCHAR(255) NOT NULL, projectName VARCHAR(255) NOT NULL, projectDesc LONGTEXT DEFAULT NULL, createdOn DATETIME DEFAULT NULL, INDEX IDX_5C93B3A435983C93 (cohort_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE projects ADD CONSTRAINT FK_5C93B3A435983C93 FOREIGN KEY (cohort_id) REFERENCES internship_cohort (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE projects DROP FOREIGN KEY FK_5C93B3A435983C93');
        $this->addSql('DROP TABLE projects');
    }
}
