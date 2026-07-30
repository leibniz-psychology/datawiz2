<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260730143223 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add costs to Data management plan';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE dmp_costs (data_management_costing VARCHAR(255) DEFAULT NULL, costs_assessment LONGTEXT DEFAULT NULL, costs_assumption LONGTEXT DEFAULT NULL, id BINARY(16) NOT NULL, data_management_plan_id BINARY(16) DEFAULT NULL, UNIQUE INDEX UNIQ_D4E7BBD0B9AD4E0E (data_management_plan_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('ALTER TABLE dmp_costs ADD CONSTRAINT FK_D4E7BBD0B9AD4E0E FOREIGN KEY (data_management_plan_id) REFERENCES data_management_plan (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE dmp_costs DROP FOREIGN KEY FK_D4E7BBD0B9AD4E0E');
        $this->addSql('DROP TABLE dmp_costs');
    }
}
