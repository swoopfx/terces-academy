<?php

declare(strict_types=1);

namespace Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230612174453 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE roles (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, dropPage VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE roles_parents (role_id INT NOT NULL, parent_id INT NOT NULL, INDEX IDX_C70E6B91D60322AC (role_id), INDEX IDX_C70E6B91727ACA70 (parent_id), PRIMARY KEY(role_id, parent_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE security_question (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE subscriberss (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, progams_id INT DEFAULT NULL, createdOn DATETIME NOT NULL, updatedOn DATETIME NOT NULL, INDEX IDX_C441EDDEA76ED395 (user_id), INDEX IDX_C441EDDECECCBA92 (progams_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, role_id INT DEFAULT NULL, state_id INT DEFAULT NULL, question_id INT DEFAULT NULL, fullname VARCHAR(255) DEFAULT NULL, username VARCHAR(30) NOT NULL, email VARCHAR(30) NOT NULL, password VARCHAR(100) NOT NULL, answer VARCHAR(255) DEFAULT NULL, registration_date DATETIME DEFAULT NULL, registration_token VARCHAR(32) DEFAULT NULL, email_confirmed TINYINT(1) NOT NULL, is_profiled TINYINT(1) DEFAULT NULL, uid VARCHAR(255) NOT NULL, uuid VARCHAR(255) NOT NULL, mobileActivateCode VARCHAR(255) DEFAULT NULL, UNIQUE INDEX UNIQ_8D93D649F85E0677 (username), UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), INDEX IDX_8D93D649D60322AC (role_id), INDEX IDX_8D93D6495D83CC1 (state_id), INDEX IDX_8D93D6491E27F6BF (question_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_state (id INT AUTO_INCREMENT NOT NULL, state VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE roles_parents ADD CONSTRAINT FK_C70E6B91D60322AC FOREIGN KEY (role_id) REFERENCES roles (id)');
        $this->addSql('ALTER TABLE roles_parents ADD CONSTRAINT FK_C70E6B91727ACA70 FOREIGN KEY (parent_id) REFERENCES roles (id)');
        $this->addSql('ALTER TABLE subscriberss ADD CONSTRAINT FK_C441EDDEA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE subscriberss ADD CONSTRAINT FK_C441EDDECECCBA92 FOREIGN KEY (progams_id) REFERENCES programss (id)');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649D60322AC FOREIGN KEY (role_id) REFERENCES roles (id)');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D6495D83CC1 FOREIGN KEY (state_id) REFERENCES user_state (id)');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D6491E27F6BF FOREIGN KEY (question_id) REFERENCES security_question (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE roles_parents DROP FOREIGN KEY FK_C70E6B91D60322AC');
        $this->addSql('ALTER TABLE roles_parents DROP FOREIGN KEY FK_C70E6B91727ACA70');
        $this->addSql('ALTER TABLE subscriberss DROP FOREIGN KEY FK_C441EDDEA76ED395');
        $this->addSql('ALTER TABLE subscriberss DROP FOREIGN KEY FK_C441EDDECECCBA92');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649D60322AC');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D6495D83CC1');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D6491E27F6BF');
        $this->addSql('DROP TABLE roles');
        $this->addSql('DROP TABLE roles_parents');
        $this->addSql('DROP TABLE security_question');
        $this->addSql('DROP TABLE subscriberss');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE user_state');
    }
}
