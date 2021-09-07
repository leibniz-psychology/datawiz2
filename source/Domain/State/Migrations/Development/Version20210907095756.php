<?php

declare(strict_types=1);

namespace App\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210907095756 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE additional_material (id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', experiment_id BINARY(16) DEFAULT NULL COMMENT \'(DC2Type:uuid)\', at_upload_nameable VARCHAR(255) NOT NULL, storage_name VARCHAR(256) DEFAULT NULL, upload_date DATETIME DEFAULT NULL, file_size VARCHAR(256) DEFAULT NULL, file_type VARCHAR(12) DEFAULT NULL, file_description VARCHAR(256) DEFAULT NULL, INDEX IDX_C66FC943FF444C8 (experiment_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE basic_information_meta_data_group (id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', experiment_id BINARY(16) DEFAULT NULL COMMENT \'(DC2Type:uuid)\', creator TEXT DEFAULT NULL COMMENT \'(DC2Type:array)\', contact TEXT DEFAULT NULL COMMENT \'(DC2Type:array)\', title TINYTEXT DEFAULT NULL, description TEXT DEFAULT NULL, related_publications TEXT DEFAULT NULL COMMENT \'(DC2Type:array)\', UNIQUE INDEX UNIQ_896C4F9FF444C8 (experiment_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE converted_dataset (id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE data_wiz_settings (id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', owner_id BINARY(16) DEFAULT NULL COMMENT \'(DC2Type:uuid)\', dummy_setting TINYINT(1) DEFAULT NULL, UNIQUE INDEX UNIQ_5A8F8A227E3C61F9 (owner_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE data_wiz_user (id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', roles JSON NOT NULL, email VARCHAR(255) DEFAULT NULL, keycloak_uuid BINARY(16) DEFAULT NULL COMMENT \'(DC2Type:uuid)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE dataset_meta_data (id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', original_dataset_id BINARY(16) DEFAULT NULL COMMENT \'(DC2Type:uuid)\', metadata JSON DEFAULT NULL, UNIQUE INDEX UNIQ_AAAE2F92B9CB5A8F (original_dataset_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE experiment (id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', owner_id BINARY(16) DEFAULT NULL COMMENT \'(DC2Type:uuid)\', INDEX IDX_136F58B27E3C61F9 (owner_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE measure_meta_data_group (id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', experiment_id BINARY(16) DEFAULT NULL COMMENT \'(DC2Type:uuid)\', measures TEXT DEFAULT NULL COMMENT \'(DC2Type:array)\', apparatus TEXT DEFAULT NULL COMMENT \'(DC2Type:array)\', UNIQUE INDEX UNIQ_649E6C87FF444C8 (experiment_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE method_meta_data_group (id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', experiment_id BINARY(16) DEFAULT NULL COMMENT \'(DC2Type:uuid)\', setting TEXT DEFAULT NULL, setting_location TEXT DEFAULT NULL, research_design TEXT DEFAULT NULL, experimental_details TEXT DEFAULT NULL, non_experimental_details TEXT DEFAULT NULL, observational_type TEXT DEFAULT NULL, manipulations TEXT DEFAULT NULL, experimental_design TEXT DEFAULT NULL, control_operations TEXT DEFAULT NULL, other_control_operations TEXT DEFAULT NULL, UNIQUE INDEX UNIQ_16979347FF444C8 (experiment_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE original_dataset (id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', experiment_id BINARY(16) DEFAULT NULL COMMENT \'(DC2Type:uuid)\', at_upload_nameable VARCHAR(255) NOT NULL, storage_name VARCHAR(256) DEFAULT NULL, INDEX IDX_3120EF27FF444C8 (experiment_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE sample_meta_data_group (id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', experiment_id BINARY(16) DEFAULT NULL COMMENT \'(DC2Type:uuid)\', participants TEXT DEFAULT NULL, inclusion_criteria TEXT DEFAULT NULL COMMENT \'(DC2Type:array)\', exclusion_criteria TEXT DEFAULT NULL COMMENT \'(DC2Type:array)\', population TEXT DEFAULT NULL COMMENT \'(DC2Type:array)\', sampling_method TEXT DEFAULT NULL, other_sampling_method TEXT DEFAULT NULL, sample_size TEXT DEFAULT NULL, power_analysis TEXT DEFAULT NULL, UNIQUE INDEX UNIQ_992D742FF444C8 (experiment_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE settings_meta_data_group (id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', experiment_id BINARY(16) DEFAULT NULL COMMENT \'(DC2Type:uuid)\', short_name VARCHAR(255) DEFAULT NULL, UNIQUE INDEX UNIQ_467B10E0FF444C8 (experiment_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE theory_meta_data_group (id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', experiment_id BINARY(16) DEFAULT NULL COMMENT \'(DC2Type:uuid)\', objective TEXT DEFAULT NULL, hypothesis TEXT DEFAULT NULL, UNIQUE INDEX UNIQ_AEA2A721FF444C8 (experiment_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE additional_material ADD CONSTRAINT FK_C66FC943FF444C8 FOREIGN KEY (experiment_id) REFERENCES experiment (id)');
        $this->addSql('ALTER TABLE basic_information_meta_data_group ADD CONSTRAINT FK_896C4F9FF444C8 FOREIGN KEY (experiment_id) REFERENCES experiment (id)');
        $this->addSql('ALTER TABLE data_wiz_settings ADD CONSTRAINT FK_5A8F8A227E3C61F9 FOREIGN KEY (owner_id) REFERENCES data_wiz_user (id)');
        $this->addSql('ALTER TABLE dataset_meta_data ADD CONSTRAINT FK_AAAE2F92B9CB5A8F FOREIGN KEY (original_dataset_id) REFERENCES original_dataset (id)');
        $this->addSql('ALTER TABLE experiment ADD CONSTRAINT FK_136F58B27E3C61F9 FOREIGN KEY (owner_id) REFERENCES data_wiz_user (id)');
        $this->addSql('ALTER TABLE measure_meta_data_group ADD CONSTRAINT FK_649E6C87FF444C8 FOREIGN KEY (experiment_id) REFERENCES experiment (id)');
        $this->addSql('ALTER TABLE method_meta_data_group ADD CONSTRAINT FK_16979347FF444C8 FOREIGN KEY (experiment_id) REFERENCES experiment (id)');
        $this->addSql('ALTER TABLE original_dataset ADD CONSTRAINT FK_3120EF27FF444C8 FOREIGN KEY (experiment_id) REFERENCES experiment (id)');
        $this->addSql('ALTER TABLE sample_meta_data_group ADD CONSTRAINT FK_992D742FF444C8 FOREIGN KEY (experiment_id) REFERENCES experiment (id)');
        $this->addSql('ALTER TABLE settings_meta_data_group ADD CONSTRAINT FK_467B10E0FF444C8 FOREIGN KEY (experiment_id) REFERENCES experiment (id)');
        $this->addSql('ALTER TABLE theory_meta_data_group ADD CONSTRAINT FK_AEA2A721FF444C8 FOREIGN KEY (experiment_id) REFERENCES experiment (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE data_wiz_settings DROP FOREIGN KEY FK_5A8F8A227E3C61F9');
        $this->addSql('ALTER TABLE experiment DROP FOREIGN KEY FK_136F58B27E3C61F9');
        $this->addSql('ALTER TABLE additional_material DROP FOREIGN KEY FK_C66FC943FF444C8');
        $this->addSql('ALTER TABLE basic_information_meta_data_group DROP FOREIGN KEY FK_896C4F9FF444C8');
        $this->addSql('ALTER TABLE measure_meta_data_group DROP FOREIGN KEY FK_649E6C87FF444C8');
        $this->addSql('ALTER TABLE method_meta_data_group DROP FOREIGN KEY FK_16979347FF444C8');
        $this->addSql('ALTER TABLE original_dataset DROP FOREIGN KEY FK_3120EF27FF444C8');
        $this->addSql('ALTER TABLE sample_meta_data_group DROP FOREIGN KEY FK_992D742FF444C8');
        $this->addSql('ALTER TABLE settings_meta_data_group DROP FOREIGN KEY FK_467B10E0FF444C8');
        $this->addSql('ALTER TABLE theory_meta_data_group DROP FOREIGN KEY FK_AEA2A721FF444C8');
        $this->addSql('ALTER TABLE dataset_meta_data DROP FOREIGN KEY FK_AAAE2F92B9CB5A8F');
        $this->addSql('DROP TABLE additional_material');
        $this->addSql('DROP TABLE basic_information_meta_data_group');
        $this->addSql('DROP TABLE converted_dataset');
        $this->addSql('DROP TABLE data_wiz_settings');
        $this->addSql('DROP TABLE data_wiz_user');
        $this->addSql('DROP TABLE dataset_meta_data');
        $this->addSql('DROP TABLE experiment');
        $this->addSql('DROP TABLE measure_meta_data_group');
        $this->addSql('DROP TABLE method_meta_data_group');
        $this->addSql('DROP TABLE original_dataset');
        $this->addSql('DROP TABLE sample_meta_data_group');
        $this->addSql('DROP TABLE settings_meta_data_group');
        $this->addSql('DROP TABLE theory_meta_data_group');
    }
}
