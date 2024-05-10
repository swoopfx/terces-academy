<?php

declare(strict_types=1);

namespace Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240509221529 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE p6room (id INT AUTO_INCREMENT NOT NULL, p6cohort_id INT UNSIGNED DEFAULT NULL, activeDate VARCHAR(255) DEFAULT NULL, isLink TINYINT(1) DEFAULT 0 NOT NULL, roomContent LONGTEXT DEFAULT NULL, createdOn DATETIME DEFAULT NULL, updatedOn DATETIME DEFAULT NULL, roomType_id INT DEFAULT NULL, oracleClasses_id INT DEFAULT NULL, INDEX IDX_C75A6FC323D9395D (p6cohort_id), INDEX IDX_C75A6FC3B28C944D (roomType_id), INDEX IDX_C75A6FC3690F396B (oracleClasses_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE p6room ADD CONSTRAINT FK_C75A6FC323D9395D FOREIGN KEY (p6cohort_id) REFERENCES p6cohort (id)');
        $this->addSql('ALTER TABLE p6room ADD CONSTRAINT FK_C75A6FC3B28C944D FOREIGN KEY (roomType_id) REFERENCES room_type (id)');
        $this->addSql('ALTER TABLE p6room ADD CONSTRAINT FK_C75A6FC3690F396B FOREIGN KEY (oracleClasses_id) REFERENCES oracle_classes (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE p6room DROP FOREIGN KEY FK_C75A6FC323D9395D');
        $this->addSql('ALTER TABLE p6room DROP FOREIGN KEY FK_C75A6FC3B28C944D');
        $this->addSql('ALTER TABLE p6room DROP FOREIGN KEY FK_C75A6FC3690F396B');
        $this->addSql('DROP TABLE p6room');
    }
}
