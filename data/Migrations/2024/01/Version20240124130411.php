<?php

declare(strict_types=1);

namespace Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240124130411 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE assignment_resos (id INT AUTO_INCREMENT NOT NULL, assignment_id INT DEFAULT NULL, createdOn VARCHAR(255) NOT NULL, aResources_id INT DEFAULT NULL, INDEX IDX_CDF41BC6D19302F8 (assignment_id), INDEX IDX_CDF41BC613090331 (aResources_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE register_cohort_resources (register_id INT NOT NULL, resources_id INT NOT NULL, INDEX IDX_17A9091A4976CB7E (register_id), UNIQUE INDEX UNIQ_17A9091AACFC5BFF (resources_id), PRIMARY KEY(register_id, resources_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE internship_resources (id INT AUTO_INCREMENT NOT NULL, cohort_id INT DEFAULT NULL, resos_id INT DEFAULT NULL, title VARCHAR(255) NOT NULL, uuid VARCHAR(255) NOT NULL, createdOn DATETIME DEFAULT NULL, updatedOn DATETIME DEFAULT NULL, INDEX IDX_5DCB80EC35983C93 (cohort_id), INDEX IDX_5DCB80EC2487A665 (resos_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE assignment_resos ADD CONSTRAINT FK_CDF41BC6D19302F8 FOREIGN KEY (assignment_id) REFERENCES assignments (id)');
        $this->addSql('ALTER TABLE assignment_resos ADD CONSTRAINT FK_CDF41BC613090331 FOREIGN KEY (aResources_id) REFERENCES resourcess (id)');
        $this->addSql('ALTER TABLE register_cohort_resources ADD CONSTRAINT FK_17A9091A4976CB7E FOREIGN KEY (register_id) REFERENCES internship_register (id)');
        $this->addSql('ALTER TABLE register_cohort_resources ADD CONSTRAINT FK_17A9091AACFC5BFF FOREIGN KEY (resources_id) REFERENCES internship_resources (id)');
        $this->addSql('ALTER TABLE internship_resources ADD CONSTRAINT FK_5DCB80EC35983C93 FOREIGN KEY (cohort_id) REFERENCES internship_cohort (id)');
        $this->addSql('ALTER TABLE internship_resources ADD CONSTRAINT FK_5DCB80EC2487A665 FOREIGN KEY (resos_id) REFERENCES image (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE assignment_resos DROP FOREIGN KEY FK_CDF41BC6D19302F8');
        $this->addSql('ALTER TABLE assignment_resos DROP FOREIGN KEY FK_CDF41BC613090331');
        $this->addSql('ALTER TABLE register_cohort_resources DROP FOREIGN KEY FK_17A9091A4976CB7E');
        $this->addSql('ALTER TABLE register_cohort_resources DROP FOREIGN KEY FK_17A9091AACFC5BFF');
        $this->addSql('ALTER TABLE internship_resources DROP FOREIGN KEY FK_5DCB80EC35983C93');
        $this->addSql('ALTER TABLE internship_resources DROP FOREIGN KEY FK_5DCB80EC2487A665');
        $this->addSql('DROP TABLE assignment_resos');
        $this->addSql('DROP TABLE register_cohort_resources');
        $this->addSql('DROP TABLE internship_resources');
    }
}
