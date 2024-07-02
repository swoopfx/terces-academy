<?php

declare(strict_types=1);

namespace Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240629115754 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE active_business_class_cohort DROP FOREIGN KEY FK_14261FA035983C93');
        $this->addSql('ALTER TABLE active_business_class_cohort ADD user_id INT DEFAULT NULL, ADD status_id INT UNSIGNED DEFAULT NULL, ADD activeUserProgram_id INT UNSIGNED DEFAULT NULL');
        $this->addSql('ALTER TABLE active_business_class_cohort ADD CONSTRAINT FK_14261FA0A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE active_business_class_cohort ADD CONSTRAINT FK_14261FA06BF700BD FOREIGN KEY (status_id) REFERENCES actvie_master_class_status (id)');
        $this->addSql('ALTER TABLE active_business_class_cohort ADD CONSTRAINT FK_14261FA080F7D477 FOREIGN KEY (activeUserProgram_id) REFERENCES active_user_program (id)');
        $this->addSql('ALTER TABLE active_business_class_cohort ADD CONSTRAINT FK_14261FA035983C93 FOREIGN KEY (cohort_id) REFERENCES master_class_cohort (id)');
        $this->addSql('CREATE INDEX IDX_14261FA0A76ED395 ON active_business_class_cohort (user_id)');
        $this->addSql('CREATE INDEX IDX_14261FA06BF700BD ON active_business_class_cohort (status_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_14261FA080F7D477 ON active_business_class_cohort (activeUserProgram_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE active_business_class_cohort DROP FOREIGN KEY FK_14261FA0A76ED395');
        $this->addSql('ALTER TABLE active_business_class_cohort DROP FOREIGN KEY FK_14261FA06BF700BD');
        $this->addSql('ALTER TABLE active_business_class_cohort DROP FOREIGN KEY FK_14261FA080F7D477');
        $this->addSql('ALTER TABLE active_business_class_cohort DROP FOREIGN KEY FK_14261FA035983C93');
        $this->addSql('DROP INDEX IDX_14261FA0A76ED395 ON active_business_class_cohort');
        $this->addSql('DROP INDEX IDX_14261FA06BF700BD ON active_business_class_cohort');
        $this->addSql('DROP INDEX UNIQ_14261FA080F7D477 ON active_business_class_cohort');
        $this->addSql('ALTER TABLE active_business_class_cohort DROP user_id, DROP status_id, DROP activeUserProgram_id');
        $this->addSql('ALTER TABLE active_business_class_cohort ADD CONSTRAINT FK_14261FA035983C93 FOREIGN KEY (cohort_id) REFERENCES certification_cohort (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
    }
}
