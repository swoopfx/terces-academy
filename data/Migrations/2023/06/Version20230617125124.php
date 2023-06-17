<?php

declare(strict_types=1);

namespace Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230617125124 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE payment_method ADD image_id INT DEFAULT NULL, ADD method VARCHAR(255) NOT NULL, ADD decription LONGTEXT DEFAULT NULL, ADD createdOn DATETIME NOT NULL, ADD updatedOn DATETIME NOT NULL, ADD isActvie TINYINT(1) DEFAULT 1 NOT NULL');
        $this->addSql('ALTER TABLE payment_method ADD CONSTRAINT FK_7B61A1F63DA5256D FOREIGN KEY (image_id) REFERENCES image (id)');
        $this->addSql('CREATE INDEX IDX_7B61A1F63DA5256D ON payment_method (image_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE payment_method DROP FOREIGN KEY FK_7B61A1F63DA5256D');
        $this->addSql('DROP INDEX IDX_7B61A1F63DA5256D ON payment_method');
        $this->addSql('ALTER TABLE payment_method DROP image_id, DROP method, DROP decription, DROP createdOn, DROP updatedOn, DROP isActvie');
    }
}
