<?php

declare(strict_types=1);

namespace Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231129194808 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE canadian_banks (id INT AUTO_INCREMENT NOT NULL, bankName VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE send_money_service (id INT AUTO_INCREMENT NOT NULL, status VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE send_money_service_type (id INT AUTO_INCREMENT NOT NULL, service VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE sent_money (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, recipientFullname VARCHAR(255) NOT NULL, recipientInteracEmail VARCHAR(255) DEFAULT NULL, account_number VARCHAR(255) DEFAULT NULL, createdOn DATETIME NOT NULL, updatedOn DATETIME NOT NULL, recipientService_id INT DEFAULT NULL, canadianBank_id INT DEFAULT NULL, INDEX IDX_B9638A6CA76ED395 (user_id), INDEX IDX_B9638A6CE81ED763 (recipientService_id), INDEX IDX_B9638A6CD23F4466 (canadianBank_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE sentmoney_sendmoneystatus (sentmoney_id INT NOT NULL, sendmoneystatus_id INT NOT NULL, INDEX IDX_1FCAE5EB1E8E54E (sentmoney_id), INDEX IDX_1FCAE5E67D9A97D (sendmoneystatus_id), PRIMARY KEY(sentmoney_id, sendmoneystatus_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE sent_money ADD CONSTRAINT FK_B9638A6CA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE sent_money ADD CONSTRAINT FK_B9638A6CE81ED763 FOREIGN KEY (recipientService_id) REFERENCES send_money_service_type (id)');
        $this->addSql('ALTER TABLE sent_money ADD CONSTRAINT FK_B9638A6CD23F4466 FOREIGN KEY (canadianBank_id) REFERENCES canadian_banks (id)');
        $this->addSql('ALTER TABLE sentmoney_sendmoneystatus ADD CONSTRAINT FK_1FCAE5EB1E8E54E FOREIGN KEY (sentmoney_id) REFERENCES sent_money (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE sentmoney_sendmoneystatus ADD CONSTRAINT FK_1FCAE5E67D9A97D FOREIGN KEY (sendmoneystatus_id) REFERENCES send_money_service (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE sent_money DROP FOREIGN KEY FK_B9638A6CA76ED395');
        $this->addSql('ALTER TABLE sent_money DROP FOREIGN KEY FK_B9638A6CE81ED763');
        $this->addSql('ALTER TABLE sent_money DROP FOREIGN KEY FK_B9638A6CD23F4466');
        $this->addSql('ALTER TABLE sentmoney_sendmoneystatus DROP FOREIGN KEY FK_1FCAE5EB1E8E54E');
        $this->addSql('ALTER TABLE sentmoney_sendmoneystatus DROP FOREIGN KEY FK_1FCAE5E67D9A97D');
        $this->addSql('DROP TABLE canadian_banks');
        $this->addSql('DROP TABLE send_money_service');
        $this->addSql('DROP TABLE send_money_service_type');
        $this->addSql('DROP TABLE sent_money');
        $this->addSql('DROP TABLE sentmoney_sendmoneystatus');
    }
}
