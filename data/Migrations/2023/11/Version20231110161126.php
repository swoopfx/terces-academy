<?php

declare(strict_types=1);

namespace Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231110161126 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE assignment_result (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, assignment_id INT DEFAULT NULL, result LONGTEXT DEFAULT NULL, createdOn DATETIME DEFAULT NULL, updatedOn DATETIME DEFAULT NULL, INDEX IDX_2B4BE10EA76ED395 (user_id), INDEX IDX_2B4BE10ED19302F8 (assignment_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE assignments (id INT AUTO_INCREMENT NOT NULL, cohort_id INT DEFAULT NULL, title VARCHAR(255) NOT NULL, content LONGTEXT DEFAULT NULL, createdOn DATETIME NOT NULL, updatedOn DATETIME NOT NULL, submitionDate DATE DEFAULT NULL, isActive TINYINT(1) DEFAULT 0 NOT NULL, INDEX IDX_308A50DD35983C93 (cohort_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE assignment_result ADD CONSTRAINT FK_2B4BE10EA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE assignment_result ADD CONSTRAINT FK_2B4BE10ED19302F8 FOREIGN KEY (assignment_id) REFERENCES assignments (id)');
        $this->addSql('ALTER TABLE assignments ADD CONSTRAINT FK_308A50DD35983C93 FOREIGN KEY (cohort_id) REFERENCES internship_cohort (id)');
        $this->addSql('ALTER TABLE image ADD assigmentResos_id INT DEFAULT NULL, ADD assignResultResos_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE image ADD CONSTRAINT FK_C53D045FC0E49C7D FOREIGN KEY (assigmentResos_id) REFERENCES assignments (id)');
        $this->addSql('ALTER TABLE image ADD CONSTRAINT FK_C53D045F13396361 FOREIGN KEY (assignResultResos_id) REFERENCES assignment_result (id)');
        $this->addSql('CREATE INDEX IDX_C53D045FC0E49C7D ON image (assigmentResos_id)');
        $this->addSql('CREATE INDEX IDX_C53D045F13396361 ON image (assignResultResos_id)');
        $this->addSql('ALTER TABLE internship_register ADD cohort_id INT DEFAULT NULL, ADD createdOn DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, ADD updatedOn DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, ADD isPayment TINYINT(1) DEFAULT 0 NOT NULL');
        $this->addSql('ALTER TABLE internship_register ADD CONSTRAINT FK_4F992AAD35983C93 FOREIGN KEY (cohort_id) REFERENCES internship_cohort (id)');
        $this->addSql('CREATE INDEX IDX_4F992AAD35983C93 ON internship_register (cohort_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE image DROP FOREIGN KEY FK_C53D045F13396361');
        $this->addSql('ALTER TABLE image DROP FOREIGN KEY FK_C53D045FC0E49C7D');
        $this->addSql('ALTER TABLE assignment_result DROP FOREIGN KEY FK_2B4BE10EA76ED395');
        $this->addSql('ALTER TABLE assignment_result DROP FOREIGN KEY FK_2B4BE10ED19302F8');
        $this->addSql('ALTER TABLE assignments DROP FOREIGN KEY FK_308A50DD35983C93');
        $this->addSql('DROP TABLE assignment_result');
        $this->addSql('DROP TABLE assignments');
        $this->addSql('DROP INDEX IDX_C53D045FC0E49C7D ON image');
        $this->addSql('DROP INDEX IDX_C53D045F13396361 ON image');
        $this->addSql('ALTER TABLE image DROP assigmentResos_id, DROP assignResultResos_id');
        $this->addSql('ALTER TABLE internship_register DROP FOREIGN KEY FK_4F992AAD35983C93');
        $this->addSql('DROP INDEX IDX_4F992AAD35983C93 ON internship_register');
        $this->addSql('ALTER TABLE internship_register DROP cohort_id, DROP createdOn, DROP updatedOn, DROP isPayment');
    }
}
