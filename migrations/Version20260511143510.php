<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260511143510 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE experiment_measure CHANGE apparatus apparatus LONGTEXT DEFAULT NULL');
        $this->addSql('ALTER TABLE experiment_method ADD randomization VARCHAR(255) DEFAULT NULL, DROP observational_type, DROP manipulations, DROP non_experimental_details, CHANGE research_method research_method LONGTEXT DEFAULT NULL');
        $this->addSql('ALTER TABLE experiment_method_measurement_instruments ADD newly_developed TINYINT DEFAULT NULL');
        $this->addSql('ALTER TABLE experiment_theory ADD exploratory_research_questions JSON DEFAULT NULL');
        $this->addSql('ALTER TABLE experiment_sample ADD participant_min_age SMALLINT DEFAULT NULL, ADD participant_max_age SMALLINT DEFAULT NULL, ADD participant_max_age_unlimited TINYINT DEFAULT NULL, ADD participant_groups_other_description LONGTEXT DEFAULT NULL, DROP inclusion_criteria, DROP exclusion_criteria, CHANGE participants participant_groups LONGTEXT DEFAULT NULL');
        $this->addSql('ALTER TABLE experiment_ethics ADD ethical_review_description LONGTEXT DEFAULT NULL, ADD data_sharing VARCHAR(255) DEFAULT NULL, ADD anonymization VARCHAR(255) DEFAULT NULL, ADD anonymization_description LONGTEXT DEFAULT NULL, ADD copyright_licenses LONGTEXT DEFAULT NULL, ADD third_party_licenses LONGTEXT DEFAULT NULL');
        $this->addSql(<<<'SQL'
            UPDATE experiment_method SET research_method = 'Survey' WHERE research_method IN ('Non-experimental');
        SQL);
        $this->addSql(<<<'SQL'
            UPDATE experiment_method SET experimental_details = NULL WHERE experimental_details IN ('Clinical trial');
        SQL);
        $this->addSql(<<<'SQL'
            UPDATE experiment_method SET setting = CASE WHEN (setting IN ('Artificial setting')) THEN 'Laboratory experiment' ELSE 'Field experiment' END
        SQL);
        $this->addSql(<<<'SQL'
            UPDATE experiment_method SET experimental_design = NULL;
        SQL);
        $this->addSql(<<<'SQL'
            UPDATE experiment_method SET experimental_details = NULL;
        SQL);
        $this->addSql(<<<'SQL'
            UPDATE experiment_measure SET apparatus = NULL;
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE experiment_measure CHANGE apparatus apparatus JSON DEFAULT NULL');
        $this->addSql('ALTER TABLE experiment_method ADD manipulations TEXT DEFAULT NULL, ADD non_experimental_details VARCHAR(255) DEFAULT NULL, CHANGE research_method research_method VARCHAR(255) DEFAULT NULL, CHANGE randomization observational_type VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE experiment_method_measurement_instruments DROP newly_developed');
        $this->addSql('ALTER TABLE experiment_theory DROP exploratory_research_questions');
        $this->addSql('ALTER TABLE experiment_sample ADD participants LONGTEXT DEFAULT NULL, ADD inclusion_criteria JSON DEFAULT NULL, ADD exclusion_criteria JSON DEFAULT NULL, DROP participant_min_age, DROP participant_max_age, DROP participant_max_age_unlimited, DROP participant_groups, DROP participant_groups_other_description');
        $this->addSql('ALTER TABLE experiment_ethics DROP ethical_review_description, DROP data_sharing, DROP anonymization, DROP anonymization_description, DROP copyright_licenses, DROP third_party_licenses');
        $this->addSql(<<<'SQL'
            UPDATE experiment_method SET research_method = NULL;
        SQL);
        $this->addSql(<<<'SQL'
            UPDATE experiment_method SET setting = CASE WHEN (setting IN ('Laboratory experiment')) THEN 'Artificial setting' ELSE 'Real-life setting' END
        SQL);
        $this->addSql(<<<'SQL'
            UPDATE experiment_method SET experimental_design = NULL;
        SQL);
        $this->addSql(<<<'SQL'
            UPDATE experiment_method SET experimental_details = NULL;
        SQL);
        $this->addSql(<<<'SQL'
            UPDATE experiment_measure SET apparatus = NULL;
        SQL);
    }
}
