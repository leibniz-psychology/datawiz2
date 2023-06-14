<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230428165114 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE dataset_variables CHANGE val_label val_label LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:json)\', CHANGE missings missings LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:json)\'');
        $this->addSql('ALTER TABLE experiment_basic CHANGE related_publications related_publications LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:json)\'');
        $this->addSql('ALTER TABLE experiment_basic_creators CHANGE credit_roles credit_roles LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:json)\'');
        $this->addSql('ALTER TABLE experiment_measure CHANGE measures measures LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:json)\', CHANGE apparatus apparatus LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:json)\'');
        $this->addSql('ALTER TABLE experiment_sample CHANGE inclusion_criteria inclusion_criteria LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:json)\', CHANGE exclusion_criteria exclusion_criteria LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:json)\', CHANGE population population LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:json)\'');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE dataset_variables CHANGE val_label val_label LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:array)\', CHANGE missings missings LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:array)\'');
        $this->addSql('ALTER TABLE experiment_basic_creators CHANGE credit_roles credit_roles LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:array)\'');
        $this->addSql('ALTER TABLE experiment_basic CHANGE related_publications related_publications TEXT DEFAULT NULL COMMENT \'(DC2Type:array)\'');
        $this->addSql('ALTER TABLE experiment_sample CHANGE inclusion_criteria inclusion_criteria TEXT DEFAULT NULL COMMENT \'(DC2Type:array)\', CHANGE exclusion_criteria exclusion_criteria TEXT DEFAULT NULL COMMENT \'(DC2Type:array)\', CHANGE population population TEXT DEFAULT NULL COMMENT \'(DC2Type:array)\'');
        $this->addSql('ALTER TABLE experiment_measure CHANGE measures measures TEXT DEFAULT NULL COMMENT \'(DC2Type:array)\', CHANGE apparatus apparatus TEXT DEFAULT NULL COMMENT \'(DC2Type:array)\'');
    }
}
