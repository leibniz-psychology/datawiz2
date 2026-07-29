<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260729131323 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'add documentation to Data management plan';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE dmp_documentation (purpose LONGTEXT DEFAULT NULL, content LONGTEXT DEFAULT NULL, standardization LONGTEXT DEFAULT NULL, generating_procedure LONGTEXT DEFAULT NULL, monitoring LONGTEXT DEFAULT NULL, exchange_and_storage_format LONGTEXT DEFAULT NULL, id BINARY(16) NOT NULL, data_management_plan_id BINARY(16) DEFAULT NULL, UNIQUE INDEX UNIQ_F26B04DCB9AD4E0E (data_management_plan_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('ALTER TABLE dmp_documentation ADD CONSTRAINT FK_F26B04DCB9AD4E0E FOREIGN KEY (data_management_plan_id) REFERENCES data_management_plan (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE dmp_documentation DROP FOREIGN KEY FK_F26B04DCB9AD4E0E');
        $this->addSql('DROP TABLE dmp_documentation');
    }
}
