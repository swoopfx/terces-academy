<?php

declare(strict_types=1);

namespace Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230706181007 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE transaction (id INT AUTO_INCREMENT NOT NULL, program_id INT DEFAULT NULL, status_id INT DEFAULT NULL, uuid VARCHAR(255) NOT NULL, transactionId VARCHAR(255) NOT NULL, createdOn DATETIME NOT NULL, updatedOn DATETIME NOT NULL, flutterWaveRef VARCHAR(255) NOT NULL, flutterWaveId VARCHAR(255) NOT NULL, amount VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_723705D1D17F50A6 (uuid), UNIQUE INDEX UNIQ_723705D1C2F43114 (transactionId), INDEX IDX_723705D13EB8070A (program_id), INDEX IDX_723705D16BF700BD (status_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE transaction_status (id INT AUTO_INCREMENT NOT NULL, status VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE transaction ADD CONSTRAINT FK_723705D13EB8070A FOREIGN KEY (program_id) REFERENCES programss (id)');
        $this->addSql('ALTER TABLE transaction ADD CONSTRAINT FK_723705D16BF700BD FOREIGN KEY (status_id) REFERENCES transaction_status (id)');
        $this->addSql('ALTER TABLE subscriberss DROP FOREIGN KEY FK_C441EDDEA76ED395');
        $this->addSql('ALTER TABLE subscriberss DROP FOREIGN KEY FK_C441EDDECECCBA92');
        $this->addSql('DROP TABLE subscriberss');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE subscriberss (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, progams_id INT DEFAULT NULL, createdOn DATETIME NOT NULL, updatedOn DATETIME NOT NULL, INDEX IDX_C441EDDECECCBA92 (progams_id), INDEX IDX_C441EDDEA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE subscriberss ADD CONSTRAINT FK_C441EDDEA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE subscriberss ADD CONSTRAINT FK_C441EDDECECCBA92 FOREIGN KEY (progams_id) REFERENCES programss (id)');
        $this->addSql('ALTER TABLE transaction DROP FOREIGN KEY FK_723705D13EB8070A');
        $this->addSql('ALTER TABLE transaction DROP FOREIGN KEY FK_723705D16BF700BD');
        $this->addSql('DROP TABLE transaction');
        $this->addSql('DROP TABLE transaction_status');
    }
}
