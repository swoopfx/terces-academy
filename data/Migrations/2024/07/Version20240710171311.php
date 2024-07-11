<?php

declare(strict_types=1);

namespace Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240710171311 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE active_business_class_cohort ADD program_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE active_business_class_cohort ADD CONSTRAINT FK_14261FA03EB8070A FOREIGN KEY (program_id) REFERENCES programss (id)');
        $this->addSql('CREATE INDEX IDX_14261FA03EB8070A ON active_business_class_cohort (program_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE active_business_class_cohort DROP FOREIGN KEY FK_14261FA03EB8070A');
        $this->addSql('DROP INDEX IDX_14261FA03EB8070A ON active_business_class_cohort');
        $this->addSql('ALTER TABLE active_business_class_cohort DROP program_id');
    }
}
