<?php

declare(strict_types=1);

namespace Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230818085122 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE active_user_program (id INT UNSIGNED AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, program_id INT DEFAULT NULL, status_id INT UNSIGNED DEFAULT NULL, isActive TINYINT(1) DEFAULT 1 NOT NULL, createdOn DATETIME NOT NULL, updatedOn DATETIME NOT NULL, uuid VARCHAR(255) NOT NULL, INDEX IDX_2BBA0E63A76ED395 (user_id), INDEX IDX_2BBA0E633EB8070A (program_id), INDEX IDX_2BBA0E636BF700BD (status_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE active_user_program_status (id INT UNSIGNED AUTO_INCREMENT NOT NULL, status VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE course_content (id INT UNSIGNED AUTO_INCREMENT NOT NULL, banner_id INT DEFAULT NULL, courses_id INT UNSIGNED DEFAULT NULL, arrange INT UNSIGNED NOT NULL, uuid VARCHAR(255) NOT NULL, title VARCHAR(255) DEFAULT NULL, snippetVideo VARCHAR(255) DEFAULT NULL, course_video VARCHAR(255) DEFAULT NULL, is_active TINYINT(1) DEFAULT NULL, created_on DATETIME DEFAULT NULL, updated_on DATETIME DEFAULT NULL, description LONGTEXT DEFAULT NULL, UNIQUE INDEX UNIQ_F6063545A3E299B1 (arrange), INDEX IDX_F6063545684EC833 (banner_id), INDEX IDX_F6063545F9295384 (courses_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE courses (id INT UNSIGNED AUTO_INCREMENT NOT NULL, programs_id INT DEFAULT NULL, banner_id INT DEFAULT NULL, video_id INT DEFAULT NULL, arrange INT UNSIGNED NOT NULL, uuid VARCHAR(255) NOT NULL, title VARCHAR(255) NOT NULL, description LONGTEXT DEFAULT NULL, createdOn DATETIME NOT NULL, updatedOn DATETIME NOT NULL, UNIQUE INDEX UNIQ_A9A55A4CA3E299B1 (arrange), INDEX IDX_A9A55A4C79AEC3C (programs_id), INDEX IDX_A9A55A4C684EC833 (banner_id), INDEX IDX_A9A55A4C29C1004E (video_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE finished_program_pool (id INT UNSIGNED AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE image (id INT AUTO_INCREMENT NOT NULL, image_uid VARCHAR(255) DEFAULT NULL, image_url VARCHAR(255) DEFAULT NULL, low_resolution VARCHAR(255) DEFAULT NULL, thumbnail VARCHAR(255) DEFAULT NULL, image_name VARCHAR(200) DEFAULT NULL, is_hidden TINYINT(1) DEFAULT NULL, mime_type VARCHAR(100) DEFAULT NULL, image_ext VARCHAR(45) DEFAULT NULL, created_on DATETIME DEFAULT NULL, updated_on DATETIME DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE news_letter (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(255) NOT NULL, activeCampaignId VARCHAR(255) DEFAULT NULL, activeCampaignResponseData LONGTEXT DEFAULT NULL, createdOn DATETIME DEFAULT NULL, updatedOn DATETIME DEFAULT NULL, UNIQUE INDEX UNIQ_2AB2D7EE7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE payment_method (id INT AUTO_INCREMENT NOT NULL, method VARCHAR(255) NOT NULL, decription LONGTEXT DEFAULT NULL, image VARCHAR(255) NOT NULL, createdOn DATETIME NOT NULL, updatedOn DATETIME NOT NULL, isActive TINYINT(1) DEFAULT 1 NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE pr_events (id INT AUTO_INCREMENT NOT NULL, eventname VARCHAR(255) NOT NULL, eventDescription LONGTEXT DEFAULT NULL, dateTimeBegin DATETIME DEFAULT NULL, dateTimeEnd DATETIME DEFAULT NULL, isActive TINYINT(1) DEFAULT NULL, createdOn DATETIME DEFAULT NULL, updatedOn DATETIME DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE programss (id INT AUTO_INCREMENT NOT NULL, uuid VARCHAR(255) NOT NULL, programId VARCHAR(255) DEFAULT NULL, cost VARCHAR(255) DEFAULT NULL, title VARCHAR(255) DEFAULT NULL, duration VARCHAR(255) DEFAULT NULL, description LONGTEXT DEFAULT NULL, createdOn DATETIME NOT NULL, updatedon DATETIME NOT NULL, isActive TINYINT(1) DEFAULT 1, banner VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE quiz (id INT AUTO_INCREMENT NOT NULL, course_id INT UNSIGNED DEFAULT NULL, uuid VARCHAR(255) NOT NULL, quizId VARCHAR(255) NOT NULL, title LONGTEXT DEFAULT NULL, createdOn DATETIME NOT NULL, updatedOn DATETIME NOT NULL, UNIQUE INDEX UNIQ_A412FA92D17F50A6 (uuid), UNIQUE INDEX UNIQ_A412FA9234A2147A (quizId), INDEX IDX_A412FA92591CC992 (course_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE quiz_question (id INT AUTO_INCREMENT NOT NULL, uuid VARCHAR(255) NOT NULL, type VARCHAR(255) NOT NULL, question LONGTEXT NOT NULL, createdOn DATETIME NOT NULL, updatedOn DATETIME NOT NULL, isActive TINYINT(1) DEFAULT 1 NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE resource_type (id INT AUTO_INCREMENT NOT NULL, type VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE resourcess (id INT AUTO_INCREMENT NOT NULL, uuid VARCHAR(255) NOT NULL, resourceTitle VARCHAR(255) NOT NULL, resourceDesc LONGTEXT DEFAULT NULL, createdOn DATETIME DEFAULT NULL, updatedOn DATETIME DEFAULT NULL, courseContent_id INT UNSIGNED DEFAULT NULL, resourcesType_id INT DEFAULT NULL, resourceFile_id INT DEFAULT NULL, INDEX IDX_2A8F270F4C0418C (courseContent_id), INDEX IDX_2A8F270FF98825FE (resourcesType_id), INDEX IDX_2A8F270F6DB94D89 (resourceFile_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE roles (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, dropPage VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE roles_parents (role_id INT NOT NULL, parent_id INT NOT NULL, INDEX IDX_C70E6B91D60322AC (role_id), INDEX IDX_C70E6B91727ACA70 (parent_id), PRIMARY KEY(role_id, parent_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE security_question (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE settings (id INT AUTO_INCREMENT NOT NULL, flutterwavePublicKey LONGTEXT NOT NULL, flutterwaveSecretKey LONGTEXT NOT NULL, flutterwaveEncKey LONGTEXT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE transaction (id INT AUTO_INCREMENT NOT NULL, program_id INT DEFAULT NULL, status_id INT DEFAULT NULL, uuid VARCHAR(255) NOT NULL, transactionId VARCHAR(255) NOT NULL, createdOn DATETIME NOT NULL, updatedOn DATETIME NOT NULL, flutterWaveRef VARCHAR(255) DEFAULT NULL, flutterWaveId VARCHAR(255) DEFAULT NULL, amount VARCHAR(255) NOT NULL, isActive TINYINT(1) DEFAULT 1 NOT NULL, paypalId VARCHAR(255) DEFAULT NULL, paypalOrderId VARCHAR(255) DEFAULT NULL, paypalConfirmData LONGTEXT DEFAULT NULL, UNIQUE INDEX UNIQ_723705D1D17F50A6 (uuid), UNIQUE INDEX UNIQ_723705D1C2F43114 (transactionId), INDEX IDX_723705D13EB8070A (program_id), INDEX IDX_723705D16BF700BD (status_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE transaction_status (id INT AUTO_INCREMENT NOT NULL, status VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, role_id INT DEFAULT NULL, state_id INT DEFAULT NULL, question_id INT DEFAULT NULL, fullname VARCHAR(255) DEFAULT NULL, username VARCHAR(30) DEFAULT NULL, email VARCHAR(30) NOT NULL, password VARCHAR(100) NOT NULL, answer VARCHAR(255) DEFAULT NULL, registration_date DATETIME DEFAULT NULL, registration_token VARCHAR(32) DEFAULT NULL, email_confirmed TINYINT(1) NOT NULL, is_profiled TINYINT(1) DEFAULT NULL, uid VARCHAR(255) NOT NULL, uuid VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), INDEX IDX_8D93D649D60322AC (role_id), INDEX IDX_8D93D6495D83CC1 (state_id), INDEX IDX_8D93D6491E27F6BF (question_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_state (id INT AUTO_INCREMENT NOT NULL, state VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE active_user_program ADD CONSTRAINT FK_2BBA0E63A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE active_user_program ADD CONSTRAINT FK_2BBA0E633EB8070A FOREIGN KEY (program_id) REFERENCES programss (id)');
        $this->addSql('ALTER TABLE active_user_program ADD CONSTRAINT FK_2BBA0E636BF700BD FOREIGN KEY (status_id) REFERENCES active_user_program_status (id)');
        $this->addSql('ALTER TABLE course_content ADD CONSTRAINT FK_F6063545684EC833 FOREIGN KEY (banner_id) REFERENCES image (id)');
        $this->addSql('ALTER TABLE course_content ADD CONSTRAINT FK_F6063545F9295384 FOREIGN KEY (courses_id) REFERENCES courses (id)');
        $this->addSql('ALTER TABLE courses ADD CONSTRAINT FK_A9A55A4C79AEC3C FOREIGN KEY (programs_id) REFERENCES programss (id)');
        $this->addSql('ALTER TABLE courses ADD CONSTRAINT FK_A9A55A4C684EC833 FOREIGN KEY (banner_id) REFERENCES image (id)');
        $this->addSql('ALTER TABLE courses ADD CONSTRAINT FK_A9A55A4C29C1004E FOREIGN KEY (video_id) REFERENCES image (id)');
        $this->addSql('ALTER TABLE quiz ADD CONSTRAINT FK_A412FA92591CC992 FOREIGN KEY (course_id) REFERENCES courses (id)');
        $this->addSql('ALTER TABLE resourcess ADD CONSTRAINT FK_2A8F270F4C0418C FOREIGN KEY (courseContent_id) REFERENCES course_content (id)');
        $this->addSql('ALTER TABLE resourcess ADD CONSTRAINT FK_2A8F270FF98825FE FOREIGN KEY (resourcesType_id) REFERENCES resource_type (id)');
        $this->addSql('ALTER TABLE resourcess ADD CONSTRAINT FK_2A8F270F6DB94D89 FOREIGN KEY (resourceFile_id) REFERENCES image (id)');
        $this->addSql('ALTER TABLE roles_parents ADD CONSTRAINT FK_C70E6B91D60322AC FOREIGN KEY (role_id) REFERENCES roles (id)');
        $this->addSql('ALTER TABLE roles_parents ADD CONSTRAINT FK_C70E6B91727ACA70 FOREIGN KEY (parent_id) REFERENCES roles (id)');
        $this->addSql('ALTER TABLE transaction ADD CONSTRAINT FK_723705D13EB8070A FOREIGN KEY (program_id) REFERENCES programss (id)');
        $this->addSql('ALTER TABLE transaction ADD CONSTRAINT FK_723705D16BF700BD FOREIGN KEY (status_id) REFERENCES transaction_status (id)');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649D60322AC FOREIGN KEY (role_id) REFERENCES roles (id)');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D6495D83CC1 FOREIGN KEY (state_id) REFERENCES user_state (id)');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D6491E27F6BF FOREIGN KEY (question_id) REFERENCES security_question (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE active_user_program DROP FOREIGN KEY FK_2BBA0E63A76ED395');
        $this->addSql('ALTER TABLE active_user_program DROP FOREIGN KEY FK_2BBA0E633EB8070A');
        $this->addSql('ALTER TABLE active_user_program DROP FOREIGN KEY FK_2BBA0E636BF700BD');
        $this->addSql('ALTER TABLE course_content DROP FOREIGN KEY FK_F6063545684EC833');
        $this->addSql('ALTER TABLE course_content DROP FOREIGN KEY FK_F6063545F9295384');
        $this->addSql('ALTER TABLE courses DROP FOREIGN KEY FK_A9A55A4C79AEC3C');
        $this->addSql('ALTER TABLE courses DROP FOREIGN KEY FK_A9A55A4C684EC833');
        $this->addSql('ALTER TABLE courses DROP FOREIGN KEY FK_A9A55A4C29C1004E');
        $this->addSql('ALTER TABLE quiz DROP FOREIGN KEY FK_A412FA92591CC992');
        $this->addSql('ALTER TABLE resourcess DROP FOREIGN KEY FK_2A8F270F4C0418C');
        $this->addSql('ALTER TABLE resourcess DROP FOREIGN KEY FK_2A8F270FF98825FE');
        $this->addSql('ALTER TABLE resourcess DROP FOREIGN KEY FK_2A8F270F6DB94D89');
        $this->addSql('ALTER TABLE roles_parents DROP FOREIGN KEY FK_C70E6B91D60322AC');
        $this->addSql('ALTER TABLE roles_parents DROP FOREIGN KEY FK_C70E6B91727ACA70');
        $this->addSql('ALTER TABLE transaction DROP FOREIGN KEY FK_723705D13EB8070A');
        $this->addSql('ALTER TABLE transaction DROP FOREIGN KEY FK_723705D16BF700BD');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649D60322AC');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D6495D83CC1');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D6491E27F6BF');
        $this->addSql('DROP TABLE active_user_program');
        $this->addSql('DROP TABLE active_user_program_status');
        $this->addSql('DROP TABLE course_content');
        $this->addSql('DROP TABLE courses');
        $this->addSql('DROP TABLE finished_program_pool');
        $this->addSql('DROP TABLE image');
        $this->addSql('DROP TABLE news_letter');
        $this->addSql('DROP TABLE payment_method');
        $this->addSql('DROP TABLE pr_events');
        $this->addSql('DROP TABLE programss');
        $this->addSql('DROP TABLE quiz');
        $this->addSql('DROP TABLE quiz_question');
        $this->addSql('DROP TABLE resource_type');
        $this->addSql('DROP TABLE resourcess');
        $this->addSql('DROP TABLE roles');
        $this->addSql('DROP TABLE roles_parents');
        $this->addSql('DROP TABLE security_question');
        $this->addSql('DROP TABLE settings');
        $this->addSql('DROP TABLE transaction');
        $this->addSql('DROP TABLE transaction_status');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE user_state');
    }
}
