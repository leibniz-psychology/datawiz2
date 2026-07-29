<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260729121700 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add research data to Data management plan';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE dmp_research_data (existing_data_reuse VARCHAR(255) DEFAULT NULL, existing_data_citation LONGTEXT DEFAULT NULL, existing_data_relevance LONGTEXT DEFAULT NULL, existing_data_integration LONGTEXT DEFAULT NULL, research_method LONGTEXT DEFAULT NULL, research_method_other_description LONGTEXT DEFAULT NULL, data_collection_reproducibility LONGTEXT DEFAULT NULL, collection_mode LONGTEXT DEFAULT NULL, collection_apparatus LONGTEXT DEFAULT NULL, collection_mode_other_description LONGTEXT DEFAULT NULL, research_design VARCHAR(255) DEFAULT NULL, data_collector_training LONGTEXT DEFAULT NULL, constructs_multiple_measurement LONGTEXT DEFAULT NULL, quality_assurance_other_description LONGTEXT DEFAULT NULL, file_formats LONGTEXT DEFAULT NULL, data_preservation_working_copy VARCHAR(255) DEFAULT NULL, data_preservation_good_scientific_practice_proof VARCHAR(255) DEFAULT NULL, data_preservation_reproducibility VARCHAR(255) DEFAULT NULL, data_preservation_legal_obligations VARCHAR(255) DEFAULT NULL, data_preservation_best_practice VARCHAR(255) DEFAULT NULL, storage_duration LONGTEXT DEFAULT NULL, deletion_procedures LONGTEXT DEFAULT NULL, data_selection VARCHAR(255) DEFAULT NULL, data_selection_time_point LONGTEXT DEFAULT NULL, data_selection_procedures LONGTEXT DEFAULT NULL, id BINARY(16) NOT NULL, data_management_plan_id BINARY(16) DEFAULT NULL, UNIQUE INDEX UNIQ_79FD6E54B9AD4E0E (data_management_plan_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('ALTER TABLE dmp_research_data ADD CONSTRAINT FK_79FD6E54B9AD4E0E FOREIGN KEY (data_management_plan_id) REFERENCES data_management_plan (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE dmp_research_data DROP FOREIGN KEY FK_79FD6E54B9AD4E0E');
        $this->addSql('DROP TABLE dmp_research_data');
    }
}
