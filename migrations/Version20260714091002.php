<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260714091002 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE data_management_plan (date_created DATETIME NOT NULL, id BINARY(16) NOT NULL, owner_id BINARY(16) DEFAULT NULL, INDEX IDX_3C03657E7E3C61F9 (owner_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE dmp_administrative_data (project_name VARCHAR(255) NOT NULL, project_goals LONGTEXT DEFAULT NULL, funding VARCHAR(255) DEFAULT NULL, project_duration VARCHAR(255) DEFAULT NULL, project_partners VARCHAR(255) DEFAULT NULL, principal_investigator VARCHAR(255) DEFAULT NULL, target_audiences LONGTEXT DEFAULT NULL, id BINARY(16) NOT NULL, data_management_plan_id BINARY(16) DEFAULT NULL, UNIQUE INDEX UNIQ_2789A68DB9AD4E0E (data_management_plan_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('ALTER TABLE data_management_plan ADD CONSTRAINT FK_3C03657E7E3C61F9 FOREIGN KEY (owner_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE dmp_administrative_data ADD CONSTRAINT FK_2789A68DB9AD4E0E FOREIGN KEY (data_management_plan_id) REFERENCES data_management_plan (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE data_management_plan DROP FOREIGN KEY FK_3C03657E7E3C61F9');
        $this->addSql('ALTER TABLE dmp_administrative_data DROP FOREIGN KEY FK_2789A68DB9AD4E0E');
        $this->addSql('DROP TABLE data_management_plan');
        $this->addSql('DROP TABLE dmp_administrative_data');
    }
}
