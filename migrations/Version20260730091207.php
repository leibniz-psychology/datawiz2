<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260730091207 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add organization and policies to Data management plan';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE dmp_organization_policies (cross_border_collaboration VARCHAR(255) DEFAULT NULL, cross_border_data_management_requirements LONGTEXT DEFAULT NULL, data_management_responsibilities LONGTEXT DEFAULT NULL, data_management_partners LONGTEXT DEFAULT NULL, partner_informed VARCHAR(255) DEFAULT NULL, partner_contributions_defined VARCHAR(255) DEFAULT NULL, partner_contributions LONGTEXT DEFAULT NULL, partner_contributions_responsibility_acceptance VARCHAR(255) DEFAULT NULL, data_management_workflow_description LONGTEXT DEFAULT NULL, staff_resource_assessment LONGTEXT DEFAULT NULL, institution_policies LONGTEXT DEFAULT NULL, data_management_plan_adherence LONGTEXT DEFAULT NULL, id BINARY(16) NOT NULL, data_management_plan_id BINARY(16) DEFAULT NULL, UNIQUE INDEX UNIQ_CBC089DB9AD4E0E (data_management_plan_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('ALTER TABLE dmp_organization_policies ADD CONSTRAINT FK_CBC089DB9AD4E0E FOREIGN KEY (data_management_plan_id) REFERENCES data_management_plan (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE dmp_organization_policies DROP FOREIGN KEY FK_CBC089DB9AD4E0E');
        $this->addSql('DROP TABLE dmp_organization_policies');
    }
}
