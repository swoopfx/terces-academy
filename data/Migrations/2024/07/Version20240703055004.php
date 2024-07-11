<?php

declare(strict_types=1);

namespace Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240703055004 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE active_business_class_cohort ADD isAll TINYINT(1) DEFAULT 0 NOT NULL');
        $this->addSql('ALTER TABLE internship_resources ADD isGeneral TINYINT(1) DEFAULT 0 NOT NULL, ADD masterClassCohort_id INT UNSIGNED DEFAULT NULL, ADD roomType_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE internship_resources ADD CONSTRAINT FK_5DCB80ECC2C6DD7C FOREIGN KEY (masterClassCohort_id) REFERENCES master_class_cohort (id)');
        $this->addSql('ALTER TABLE internship_resources ADD CONSTRAINT FK_5DCB80ECB28C944D FOREIGN KEY (roomType_id) REFERENCES room_type (id)');
        $this->addSql('CREATE INDEX IDX_5DCB80ECC2C6DD7C ON internship_resources (masterClassCohort_id)');
        $this->addSql('CREATE INDEX IDX_5DCB80ECB28C944D ON internship_resources (roomType_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE active_business_class_cohort DROP isAll');
        $this->addSql('ALTER TABLE internship_resources DROP FOREIGN KEY FK_5DCB80ECC2C6DD7C');
        $this->addSql('ALTER TABLE internship_resources DROP FOREIGN KEY FK_5DCB80ECB28C944D');
        $this->addSql('DROP INDEX IDX_5DCB80ECC2C6DD7C ON internship_resources');
        $this->addSql('DROP INDEX IDX_5DCB80ECB28C944D ON internship_resources');
        $this->addSql('ALTER TABLE internship_resources DROP isGeneral, DROP masterClassCohort_id, DROP roomType_id');
    }
}
