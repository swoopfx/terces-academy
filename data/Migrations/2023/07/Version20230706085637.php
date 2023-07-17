<?php

declare(strict_types=1);

namespace Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230706085637 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE active_user_program (id INT UNSIGNED AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, program_id INT DEFAULT NULL, isActive TINYINT(1) DEFAULT 1 NOT NULL, createdOn DATETIME NOT NULL, updatedOn DATETIME NOT NULL, INDEX IDX_2BBA0E63A76ED395 (user_id), INDEX IDX_2BBA0E633EB8070A (program_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE active_user_program ADD CONSTRAINT FK_2BBA0E63A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE active_user_program ADD CONSTRAINT FK_2BBA0E633EB8070A FOREIGN KEY (program_id) REFERENCES programss (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE active_user_program DROP FOREIGN KEY FK_2BBA0E63A76ED395');
        $this->addSql('ALTER TABLE active_user_program DROP FOREIGN KEY FK_2BBA0E633EB8070A');
        $this->addSql('DROP TABLE active_user_program');
    }
}
