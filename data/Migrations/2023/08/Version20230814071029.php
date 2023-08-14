<?php

declare(strict_types=1);

namespace Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230814071029 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE active_user_program ADD status_id INT UNSIGNED DEFAULT NULL');
        $this->addSql('ALTER TABLE active_user_program ADD CONSTRAINT FK_2BBA0E636BF700BD FOREIGN KEY (status_id) REFERENCES active_user_program_status (id)');
        $this->addSql('CREATE INDEX IDX_2BBA0E636BF700BD ON active_user_program (status_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE active_user_program DROP FOREIGN KEY FK_2BBA0E636BF700BD');
        $this->addSql('DROP INDEX IDX_2BBA0E636BF700BD ON active_user_program');
        $this->addSql('ALTER TABLE active_user_program DROP status_id');
    }
}
