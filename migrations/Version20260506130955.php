<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260506130955 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add more fields to experiment_sample table';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE experiment_measure DROP sampling_method, DROP sampling_method_other_description, DROP recruiting');
        $this->addSql('ALTER TABLE experiment_sample ADD sampling_method_other_description LONGTEXT DEFAULT NULL, ADD recruiting LONGTEXT DEFAULT NULL, ADD intended_sample_size VARCHAR(255) DEFAULT NULL, ADD unit_of_analysis VARCHAR(255) DEFAULT NULL, ADD unit_of_analysis_other_description LONGTEXT DEFAULT NULL, ADD multilevel_structure LONGTEXT DEFAULT NULL, ADD sex VARCHAR(255) DEFAULT NULL, ADD age VARCHAR(255) DEFAULT NULL, ADD special_groups VARCHAR(255) DEFAULT NULL, ADD country VARCHAR(255) DEFAULT NULL, ADD city VARCHAR(255) DEFAULT NULL, ADD region VARCHAR(255) DEFAULT NULL, ADD missing_values LONGTEXT DEFAULT NULL, ADD return_dropout LONGTEXT DEFAULT NULL, DROP other_sampling_method, CHANGE participants participants LONGTEXT DEFAULT NULL, CHANGE sampling_method sampling_method VARCHAR(255) DEFAULT NULL');
        $this->addSql(<<<'SQL'
            UPDATE experiment_sample SET sampling_method = NULL
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE experiment_measure ADD sampling_method VARCHAR(255) DEFAULT NULL, ADD sampling_method_other_description LONGTEXT DEFAULT NULL, ADD recruiting LONGTEXT DEFAULT NULL');
        $this->addSql('ALTER TABLE experiment_sample ADD other_sampling_method TEXT DEFAULT NULL, DROP sampling_method_other_description, DROP recruiting, DROP intended_sample_size, DROP unit_of_analysis, DROP unit_of_analysis_other_description, DROP multilevel_structure, DROP sex, DROP age, DROP special_groups, DROP country, DROP city, DROP region, DROP missing_values, DROP return_dropout, CHANGE participants participants TEXT DEFAULT NULL, CHANGE sampling_method sampling_method TEXT DEFAULT NULL');
        $this->addSql(<<<'SQL'
            UPDATE experiment_sample SET sampling_method = NULL
        SQL);
    }
}
