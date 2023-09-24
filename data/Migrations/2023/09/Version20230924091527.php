<?php

declare(strict_types=1);

namespace Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230924091527 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE interac_payment (id INT UNSIGNED AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, amount VARCHAR(255) NOT NULL, interacEmail VARCHAR(255) NOT NULL, uuid VARCHAR(255) NOT NULL, isConfirmed TINYINT(1) DEFAULT 0 NOT NULL, isFailed TINYINT(1) DEFAULT 0 NOT NULL, isProcessed TINYINT(1) DEFAULT 0 NOT NULL, createdOn DATETIME DEFAULT NULL, updatedOn DATETIME DEFAULT NULL, UNIQUE INDEX UNIQ_EFA205CCD17F50A6 (uuid), INDEX IDX_EFA205CCA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE interac_payment ADD CONSTRAINT FK_EFA205CCA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE interac_payment DROP FOREIGN KEY FK_EFA205CCA76ED395');
        $this->addSql('DROP TABLE interac_payment');
    }
}
