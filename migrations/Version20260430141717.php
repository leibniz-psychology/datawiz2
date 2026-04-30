<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260430141717 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add more fields to experiment_method table';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE experiment_method_constructs (name VARCHAR(255) DEFAULT NULL, construct_function VARCHAR(255) DEFAULT NULL, other_function_description LONGTEXT DEFAULT NULL, id BINARY(16) NOT NULL, method_id BINARY(16) DEFAULT NULL, INDEX IDX_4DB0B5AA19883967 (method_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE experiment_method_measurement_instruments (title VARCHAR(255) DEFAULT NULL, author LONGTEXT DEFAULT NULL, citation LONGTEXT DEFAULT NULL, abstract LONGTEXT DEFAULT NULL, theoretical_background LONGTEXT DEFAULT NULL, structure LONGTEXT DEFAULT NULL, development LONGTEXT DEFAULT NULL, objectivity LONGTEXT DEFAULT NULL, reliability LONGTEXT DEFAULT NULL, validity LONGTEXT DEFAULT NULL, norm_referenced LONGTEXT DEFAULT NULL, id BINARY(16) NOT NULL, method_id BINARY(16) DEFAULT NULL, INDEX IDX_B85D984519883967 (method_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE experiment_method_measurement_occasions (time_of_measurement VARCHAR(255) DEFAULT NULL, intervention TINYINT DEFAULT NULL, position INT DEFAULT NULL, id BINARY(16) NOT NULL, method_id BINARY(16) DEFAULT NULL, INDEX IDX_F543FB4719883967 (method_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('ALTER TABLE experiment_method_constructs ADD CONSTRAINT FK_4DB0B5AA19883967 FOREIGN KEY (method_id) REFERENCES experiment_method (id)');
        $this->addSql('ALTER TABLE experiment_method_measurement_instruments ADD CONSTRAINT FK_B85D984519883967 FOREIGN KEY (method_id) REFERENCES experiment_method (id)');
        $this->addSql('ALTER TABLE experiment_method_measurement_occasions ADD CONSTRAINT FK_F543FB4719883967 FOREIGN KEY (method_id) REFERENCES experiment_method (id)');
        $this->addSql('ALTER TABLE experiment_method ADD research_design VARCHAR(255) DEFAULT NULL, ADD research_design_description LONGTEXT DEFAULT NULL, ADD survey_instrument_type VARCHAR(255) DEFAULT NULL, ADD treatment_groups JSON DEFAULT NULL, ADD research_method_description LONGTEXT DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE experiment_method_constructs DROP FOREIGN KEY FK_4DB0B5AA19883967');
        $this->addSql('ALTER TABLE experiment_method_measurement_instruments DROP FOREIGN KEY FK_B85D984519883967');
        $this->addSql('ALTER TABLE experiment_method_measurement_occasions DROP FOREIGN KEY FK_F543FB4719883967');
        $this->addSql('DROP TABLE experiment_method_constructs');
        $this->addSql('DROP TABLE experiment_method_measurement_instruments');
        $this->addSql('DROP TABLE experiment_method_measurement_occasions');
        $this->addSql('ALTER TABLE experiment_method DROP research_design, DROP research_design_description, DROP survey_instrument_type, DROP treatment_groups, DROP research_method_description');
    }
}
