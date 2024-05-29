<?php

declare(strict_types=1);

namespace Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240529080459 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE active_certification (id INT UNSIGNED AUTO_INCREMENT NOT NULL, cohort_id INT UNSIGNED DEFAULT NULL, status_id INT UNSIGNED DEFAULT NULL, isActive TINYINT(1) DEFAULT 1 NOT NULL, createdOn DATETIME NOT NULL, updatedOn DATETIME NOT NULL, uuid VARCHAR(255) NOT NULL, activeUserProgram_id INT UNSIGNED DEFAULT NULL, UNIQUE INDEX UNIQ_B266A9D7D17F50A6 (uuid), INDEX IDX_B266A9D735983C93 (cohort_id), INDEX IDX_B266A9D76BF700BD (status_id), UNIQUE INDEX UNIQ_B266A9D780F7D477 (activeUserProgram_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE active_certification_status (id INT UNSIGNED AUTO_INCREMENT NOT NULL, status VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE certification_cohort (id INT UNSIGNED AUTO_INCREMENT NOT NULL, cohortName VARCHAR(255) NOT NULL, startDate DATETIME NOT NULL, uuid VARCHAR(255) NOT NULL, createdOn DATETIME NOT NULL, isActive TINYINT(1) NOT NULL, UNIQUE INDEX UNIQ_3590D8DCD17F50A6 (uuid), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE active_certification ADD CONSTRAINT FK_B266A9D735983C93 FOREIGN KEY (cohort_id) REFERENCES certification_cohort (id)');
        $this->addSql('ALTER TABLE active_certification ADD CONSTRAINT FK_B266A9D76BF700BD FOREIGN KEY (status_id) REFERENCES active_certification_status (id)');
        $this->addSql('ALTER TABLE active_certification ADD CONSTRAINT FK_B266A9D780F7D477 FOREIGN KEY (activeUserProgram_id) REFERENCES active_user_program (id)');
        $this->addSql('ALTER TABLE internship_cohort ADD isActive TINYINT(1) DEFAULT 1 NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE active_certification DROP FOREIGN KEY FK_B266A9D735983C93');
        $this->addSql('ALTER TABLE active_certification DROP FOREIGN KEY FK_B266A9D76BF700BD');
        $this->addSql('ALTER TABLE active_certification DROP FOREIGN KEY FK_B266A9D780F7D477');
        $this->addSql('DROP TABLE active_certification');
        $this->addSql('DROP TABLE active_certification_status');
        $this->addSql('DROP TABLE certification_cohort');
        $this->addSql('ALTER TABLE internship_cohort DROP isActive');
    }
}
