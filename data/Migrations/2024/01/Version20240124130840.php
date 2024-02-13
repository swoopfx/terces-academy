<?php

declare(strict_types=1);

namespace Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240124130840 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE register_cohort_resources DROP INDEX IDX_17A9091AACFC5BFF, ADD UNIQUE INDEX UNIQ_17A9091AACFC5BFF (resources_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE register_cohort_resources DROP INDEX UNIQ_17A9091AACFC5BFF, ADD INDEX IDX_17A9091AACFC5BFF (resources_id)');
    }
}
