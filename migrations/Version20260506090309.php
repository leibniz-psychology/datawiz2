<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260506090309 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE experiment_measure ADD data_collection_start DATE DEFAULT NULL, ADD data_collection_end DATE DEFAULT NULL, ADD collection_mode LONGTEXT DEFAULT NULL, ADD collection_mode_other_description LONGTEXT DEFAULT NULL, ADD sampling_method VARCHAR(255) DEFAULT NULL, ADD sampling_method_other_description LONGTEXT DEFAULT NULL, ADD recruiting LONGTEXT DEFAULT NULL, ADD original_record_type LONGTEXT DEFAULT NULL, ADD original_record_type_other_description LONGTEXT DEFAULT NULL, ADD raw_data_digitization VARCHAR(255) DEFAULT NULL, ADD raw_data_digitization_description LONGTEXT DEFAULT NULL, ADD special_circumstances LONGTEXT DEFAULT NULL, ADD raw_data_transformation LONGTEXT DEFAULT NULL, ADD quality_indicators LONGTEXT DEFAULT NULL, ADD limitations LONGTEXT DEFAULT NULL, DROP measures');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE experiment_measure ADD measures JSON DEFAULT NULL, DROP data_collection_start, DROP data_collection_end, DROP collection_mode, DROP collection_mode_other_description, DROP sampling_method, DROP sampling_method_other_description, DROP recruiting, DROP original_record_type, DROP original_record_type_other_description, DROP raw_data_digitization, DROP raw_data_digitization_description, DROP special_circumstances, DROP raw_data_transformation, DROP quality_indicators, DROP limitations');
    }
}
