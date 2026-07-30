<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260730083803 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add storage infrastructure to Data management plan';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE dmp_storage_infrastructure (responsibilities LONGTEXT DEFAULT NULL, naming_conventions LONGTEXT DEFAULT NULL, storage_locations LONGTEXT DEFAULT NULL, backup_plan LONGTEXT DEFAULT NULL, transfer_during_project LONGTEXT DEFAULT NULL, expected_volume LONGTEXT DEFAULT NULL, specific_technical_requirements LONGTEXT DEFAULT NULL, succession_plan LONGTEXT DEFAULT NULL, id BINARY(16) NOT NULL, data_management_plan_id BINARY(16) DEFAULT NULL, UNIQUE INDEX UNIQ_176EB902B9AD4E0E (data_management_plan_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('ALTER TABLE dmp_storage_infrastructure ADD CONSTRAINT FK_176EB902B9AD4E0E FOREIGN KEY (data_management_plan_id) REFERENCES data_management_plan (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE dmp_storage_infrastructure DROP FOREIGN KEY FK_176EB902B9AD4E0E');
        $this->addSql('DROP TABLE dmp_storage_infrastructure');
    }
}
