<?php

declare(strict_types=1);

namespace App\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210914113900 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE experiment_measure (id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', experiment_id BINARY(16) DEFAULT NULL COMMENT \'(DC2Type:uuid)\', measures TEXT DEFAULT NULL COMMENT \'(DC2Type:array)\', apparatus TEXT DEFAULT NULL COMMENT \'(DC2Type:array)\', UNIQUE INDEX UNIQ_AE44DE8FFF444C8 (experiment_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE experiment_method (id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', experiment_id BINARY(16) DEFAULT NULL COMMENT \'(DC2Type:uuid)\', setting TEXT DEFAULT NULL, setting_location TEXT DEFAULT NULL, research_design TEXT DEFAULT NULL, experimental_details TEXT DEFAULT NULL, non_experimental_details TEXT DEFAULT NULL, observational_type TEXT DEFAULT NULL, manipulations TEXT DEFAULT NULL, experimental_design TEXT DEFAULT NULL, control_operations TEXT DEFAULT NULL, other_control_operations TEXT DEFAULT NULL, UNIQUE INDEX UNIQ_A993111DFF444C8 (experiment_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE experiment_sample (id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', experiment_id BINARY(16) DEFAULT NULL COMMENT \'(DC2Type:uuid)\', participants TEXT DEFAULT NULL, inclusion_criteria TEXT DEFAULT NULL COMMENT \'(DC2Type:array)\', exclusion_criteria TEXT DEFAULT NULL COMMENT \'(DC2Type:array)\', population TEXT DEFAULT NULL COMMENT \'(DC2Type:array)\', sampling_method TEXT DEFAULT NULL, other_sampling_method TEXT DEFAULT NULL, sample_size TEXT DEFAULT NULL, power_analysis TEXT DEFAULT NULL, UNIQUE INDEX UNIQ_6C15DBEFF444C8 (experiment_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE experiment_settings (id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', experiment_id BINARY(16) DEFAULT NULL COMMENT \'(DC2Type:uuid)\', short_name VARCHAR(255) DEFAULT NULL, UNIQUE INDEX UNIQ_D368A9F4FF444C8 (experiment_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE experiment_theory (id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', experiment_id BINARY(16) DEFAULT NULL COMMENT \'(DC2Type:uuid)\', objective TEXT DEFAULT NULL, hypothesis TEXT DEFAULT NULL, UNIQUE INDEX UNIQ_45AA045FF444C8 (experiment_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE experiment_measure ADD CONSTRAINT FK_AE44DE8FFF444C8 FOREIGN KEY (experiment_id) REFERENCES experiment (id)');
        $this->addSql('ALTER TABLE experiment_method ADD CONSTRAINT FK_A993111DFF444C8 FOREIGN KEY (experiment_id) REFERENCES experiment (id)');
        $this->addSql('ALTER TABLE experiment_sample ADD CONSTRAINT FK_6C15DBEFF444C8 FOREIGN KEY (experiment_id) REFERENCES experiment (id)');
        $this->addSql('ALTER TABLE experiment_settings ADD CONSTRAINT FK_D368A9F4FF444C8 FOREIGN KEY (experiment_id) REFERENCES experiment (id)');
        $this->addSql('ALTER TABLE experiment_theory ADD CONSTRAINT FK_45AA045FF444C8 FOREIGN KEY (experiment_id) REFERENCES experiment (id)');
        $this->addSql('DROP TABLE measure_meta_data_group');
        $this->addSql('DROP TABLE method_meta_data_group');
        $this->addSql('DROP TABLE sample_meta_data_group');
        $this->addSql('DROP TABLE settings_meta_data_group');
        $this->addSql('DROP TABLE theory_meta_data_group');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE measure_meta_data_group (id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', experiment_id BINARY(16) DEFAULT NULL COMMENT \'(DC2Type:uuid)\', measures TEXT CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci` COMMENT \'(DC2Type:array)\', apparatus TEXT CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci` COMMENT \'(DC2Type:array)\', UNIQUE INDEX UNIQ_649E6C87FF444C8 (experiment_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE method_meta_data_group (id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', experiment_id BINARY(16) DEFAULT NULL COMMENT \'(DC2Type:uuid)\', setting TEXT CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, setting_location TEXT CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, research_design TEXT CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, experimental_details TEXT CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, non_experimental_details TEXT CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, observational_type TEXT CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, manipulations TEXT CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, experimental_design TEXT CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, control_operations TEXT CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, other_control_operations TEXT CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, UNIQUE INDEX UNIQ_16979347FF444C8 (experiment_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE sample_meta_data_group (id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', experiment_id BINARY(16) DEFAULT NULL COMMENT \'(DC2Type:uuid)\', participants TEXT CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, inclusion_criteria TEXT CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci` COMMENT \'(DC2Type:array)\', exclusion_criteria TEXT CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci` COMMENT \'(DC2Type:array)\', population TEXT CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci` COMMENT \'(DC2Type:array)\', sampling_method TEXT CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, other_sampling_method TEXT CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, sample_size TEXT CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, power_analysis TEXT CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, UNIQUE INDEX UNIQ_992D742FF444C8 (experiment_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE settings_meta_data_group (id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', experiment_id BINARY(16) DEFAULT NULL COMMENT \'(DC2Type:uuid)\', short_name VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, UNIQUE INDEX UNIQ_467B10E0FF444C8 (experiment_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE theory_meta_data_group (id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', experiment_id BINARY(16) DEFAULT NULL COMMENT \'(DC2Type:uuid)\', objective TEXT CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, hypothesis TEXT CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, UNIQUE INDEX UNIQ_AEA2A721FF444C8 (experiment_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE measure_meta_data_group ADD CONSTRAINT FK_649E6C87FF444C8 FOREIGN KEY (experiment_id) REFERENCES experiment (id)');
        $this->addSql('ALTER TABLE method_meta_data_group ADD CONSTRAINT FK_16979347FF444C8 FOREIGN KEY (experiment_id) REFERENCES experiment (id)');
        $this->addSql('ALTER TABLE sample_meta_data_group ADD CONSTRAINT FK_992D742FF444C8 FOREIGN KEY (experiment_id) REFERENCES experiment (id)');
        $this->addSql('ALTER TABLE settings_meta_data_group ADD CONSTRAINT FK_467B10E0FF444C8 FOREIGN KEY (experiment_id) REFERENCES experiment (id)');
        $this->addSql('ALTER TABLE theory_meta_data_group ADD CONSTRAINT FK_AEA2A721FF444C8 FOREIGN KEY (experiment_id) REFERENCES experiment (id)');
        $this->addSql('DROP TABLE experiment_measure');
        $this->addSql('DROP TABLE experiment_method');
        $this->addSql('DROP TABLE experiment_sample');
        $this->addSql('DROP TABLE experiment_settings');
        $this->addSql('DROP TABLE experiment_theory');
    }
}
