<?php

declare(strict_types=1);

namespace Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240717065801 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE p6_free_cohort ADD cohortName VARCHAR(255) NOT NULL, ADD createdOn DATETIME NOT NULL, DROP cohort, CHANGE isActive isActive TINYINT(1) NOT NULL, CHANGE uuid uuid VARCHAR(255) NOT NULL, CHANGE startDate startDate DATETIME NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE p6_free_cohort ADD cohort VARCHAR(255) DEFAULT NULL, DROP cohortName, DROP createdOn, CHANGE startDate startDate DATE NOT NULL, CHANGE uuid uuid VARCHAR(255) DEFAULT NULL, CHANGE isActive isActive TINYINT(1) DEFAULT 1 NOT NULL');
    }
}
