<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260730124108 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add ethical and legal information to Data management plan';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE dmp_ethical_legal (ethical_review LONGTEXT DEFAULT NULL, informed_consent VARCHAR(255) DEFAULT NULL, informed_consent_data_sharing VARCHAR(255) DEFAULT NULL, no_informed_consent_reason LONGTEXT DEFAULT NULL, personal_data VARCHAR(255) DEFAULT NULL, personal_data_protection_measures LONGTEXT DEFAULT NULL, commercial_sensitive_data VARCHAR(255) DEFAULT NULL, commercial_data_protection_measures LONGTEXT DEFAULT NULL, copyright VARCHAR(255) DEFAULT NULL, copyright_licenses LONGTEXT DEFAULT NULL, third_party_rights VARCHAR(255) DEFAULT NULL, third_party_licenses LONGTEXT DEFAULT NULL, id BINARY(16) NOT NULL, data_management_plan_id BINARY(16) DEFAULT NULL, UNIQUE INDEX UNIQ_909ED6DEB9AD4E0E (data_management_plan_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('ALTER TABLE dmp_ethical_legal ADD CONSTRAINT FK_909ED6DEB9AD4E0E FOREIGN KEY (data_management_plan_id) REFERENCES data_management_plan (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE dmp_ethical_legal DROP FOREIGN KEY FK_909ED6DEB9AD4E0E');
        $this->addSql('DROP TABLE dmp_ethical_legal');
    }
}
