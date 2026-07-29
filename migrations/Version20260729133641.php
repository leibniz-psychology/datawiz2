<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260729133641 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'add data sharing to Data management plan';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE dmp_data_sharing (sharing_obligation VARCHAR(255) DEFAULT NULL, intended_use LONGTEXT DEFAULT NULL, third_party_access VARCHAR(255) DEFAULT NULL, repository_name LONGTEXT DEFAULT NULL, data_searchability LONGTEXT DEFAULT NULL, deposit_timepoint LONGTEXT DEFAULT NULL, sensitive_data_requirements LONGTEXT DEFAULT NULL, initial_use_right LONGTEXT DEFAULT NULL, usage_restriction LONGTEXT DEFAULT NULL, access_cost VARCHAR(255) DEFAULT NULL, repository_responsibilities_fixation VARCHAR(255) DEFAULT NULL, acquisition_agreement VARCHAR(255) DEFAULT NULL, persistent_identifier_use VARCHAR(255) DEFAULT NULL, persistent_identifier_use_other_description LONGTEXT DEFAULT NULL, no_repository_explanation LONGTEXT DEFAULT NULL, no_sharing_explanation VARCHAR(255) DEFAULT NULL, no_sharing_explanation_other_description LONGTEXT DEFAULT NULL, id BINARY(16) NOT NULL, data_management_plan_id BINARY(16) DEFAULT NULL, UNIQUE INDEX UNIQ_CA31904DB9AD4E0E (data_management_plan_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('ALTER TABLE dmp_data_sharing ADD CONSTRAINT FK_CA31904DB9AD4E0E FOREIGN KEY (data_management_plan_id) REFERENCES data_management_plan (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE dmp_data_sharing DROP FOREIGN KEY FK_CA31904DB9AD4E0E');
        $this->addSql('DROP TABLE dmp_data_sharing');
    }
}
