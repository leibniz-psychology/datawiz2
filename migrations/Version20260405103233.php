<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260405103233 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'remove comment from uuid entities';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE dataset CHANGE id id BINARY(16) NOT NULL, CHANGE experiment_id experiment_id BINARY(16) DEFAULT NULL');
        $this->addSql('ALTER TABLE dataset_variables CHANGE id id BINARY(16) NOT NULL, CHANGE dataset_id dataset_id BINARY(16) DEFAULT NULL, CHANGE val_label val_label JSON DEFAULT NULL, CHANGE missings missings JSON DEFAULT NULL');
        $this->addSql('ALTER TABLE experiment CHANGE id id BINARY(16) NOT NULL, CHANGE owner_id owner_id BINARY(16) DEFAULT NULL');
        $this->addSql('ALTER TABLE experiment_basic CHANGE id id BINARY(16) NOT NULL, CHANGE experiment_id experiment_id BINARY(16) DEFAULT NULL, CHANGE related_publications related_publications JSON DEFAULT NULL');
        $this->addSql('ALTER TABLE experiment_basic_creators CHANGE id id BINARY(16) NOT NULL, CHANGE basic_id basic_id BINARY(16) DEFAULT NULL, CHANGE credit_roles credit_roles JSON DEFAULT NULL');
        $this->addSql('ALTER TABLE experiment_measure CHANGE id id BINARY(16) NOT NULL, CHANGE experiment_id experiment_id BINARY(16) DEFAULT NULL, CHANGE measures measures JSON DEFAULT NULL, CHANGE apparatus apparatus JSON DEFAULT NULL');
        $this->addSql('ALTER TABLE experiment_method CHANGE id id BINARY(16) NOT NULL, CHANGE experiment_id experiment_id BINARY(16) DEFAULT NULL');
        $this->addSql('ALTER TABLE experiment_sample CHANGE id id BINARY(16) NOT NULL, CHANGE experiment_id experiment_id BINARY(16) DEFAULT NULL, CHANGE inclusion_criteria inclusion_criteria JSON DEFAULT NULL, CHANGE exclusion_criteria exclusion_criteria JSON DEFAULT NULL, CHANGE population population JSON DEFAULT NULL');
        $this->addSql('ALTER TABLE experiment_settings CHANGE id id BINARY(16) NOT NULL, CHANGE experiment_id experiment_id BINARY(16) DEFAULT NULL');
        $this->addSql('ALTER TABLE experiment_theory CHANGE id id BINARY(16) NOT NULL, CHANGE experiment_id experiment_id BINARY(16) DEFAULT NULL');
        $this->addSql('ALTER TABLE material CHANGE id id BINARY(16) NOT NULL, CHANGE experiment_id experiment_id BINARY(16) DEFAULT NULL');
        $this->addSql('ALTER TABLE user CHANGE id id BINARY(16) NOT NULL, CHANGE roles roles LONGTEXT NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE dataset CHANGE id id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', CHANGE experiment_id experiment_id BINARY(16) DEFAULT NULL COMMENT \'(DC2Type:uuid)\'');
        $this->addSql('ALTER TABLE dataset_variables CHANGE val_label val_label JSON DEFAULT NULL COMMENT \'(DC2Type:json)\', CHANGE missings missings JSON DEFAULT NULL COMMENT \'(DC2Type:json)\', CHANGE id id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', CHANGE dataset_id dataset_id BINARY(16) DEFAULT NULL COMMENT \'(DC2Type:uuid)\'');
        $this->addSql('ALTER TABLE experiment CHANGE id id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', CHANGE owner_id owner_id BINARY(16) DEFAULT NULL COMMENT \'(DC2Type:uuid)\'');
        $this->addSql('ALTER TABLE experiment_basic CHANGE related_publications related_publications JSON DEFAULT NULL COMMENT \'(DC2Type:json)\', CHANGE id id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', CHANGE experiment_id experiment_id BINARY(16) DEFAULT NULL COMMENT \'(DC2Type:uuid)\'');
        $this->addSql('ALTER TABLE experiment_basic_creators CHANGE credit_roles credit_roles JSON DEFAULT NULL COMMENT \'(DC2Type:json)\', CHANGE id id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', CHANGE basic_id basic_id BINARY(16) DEFAULT NULL COMMENT \'(DC2Type:uuid)\'');
        $this->addSql('ALTER TABLE experiment_measure CHANGE measures measures JSON DEFAULT NULL COMMENT \'(DC2Type:json)\', CHANGE apparatus apparatus JSON DEFAULT NULL COMMENT \'(DC2Type:json)\', CHANGE id id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', CHANGE experiment_id experiment_id BINARY(16) DEFAULT NULL COMMENT \'(DC2Type:uuid)\'');
        $this->addSql('ALTER TABLE experiment_method CHANGE id id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', CHANGE experiment_id experiment_id BINARY(16) DEFAULT NULL COMMENT \'(DC2Type:uuid)\'');
        $this->addSql('ALTER TABLE experiment_sample CHANGE inclusion_criteria inclusion_criteria JSON DEFAULT NULL COMMENT \'(DC2Type:json)\', CHANGE exclusion_criteria exclusion_criteria JSON DEFAULT NULL COMMENT \'(DC2Type:json)\', CHANGE population population JSON DEFAULT NULL COMMENT \'(DC2Type:json)\', CHANGE id id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', CHANGE experiment_id experiment_id BINARY(16) DEFAULT NULL COMMENT \'(DC2Type:uuid)\'');
        $this->addSql('ALTER TABLE experiment_settings CHANGE id id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', CHANGE experiment_id experiment_id BINARY(16) DEFAULT NULL COMMENT \'(DC2Type:uuid)\'');
        $this->addSql('ALTER TABLE experiment_theory CHANGE id id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', CHANGE experiment_id experiment_id BINARY(16) DEFAULT NULL COMMENT \'(DC2Type:uuid)\'');
        $this->addSql('ALTER TABLE material CHANGE id id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', CHANGE experiment_id experiment_id BINARY(16) DEFAULT NULL COMMENT \'(DC2Type:uuid)\'');
        $this->addSql('ALTER TABLE user CHANGE id id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', CHANGE roles roles LONGTEXT NOT NULL COMMENT \'(DC2Type:simple_array)\'');
    }
}
