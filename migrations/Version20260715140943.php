<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260715140943 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add settings for data management plans';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE dmp_settings (short_name VARCHAR(255) DEFAULT NULL, id BINARY(16) NOT NULL, data_management_plan_id BINARY(16) DEFAULT NULL, UNIQUE INDEX UNIQ_10043EB4B9AD4E0E (data_management_plan_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('ALTER TABLE dmp_settings ADD CONSTRAINT FK_10043EB4B9AD4E0E FOREIGN KEY (data_management_plan_id) REFERENCES data_management_plan (id)');
        $this->addSql('ALTER TABLE dmp_administrative_data CHANGE project_name project_name VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE dmp_settings DROP FOREIGN KEY FK_10043EB4B9AD4E0E');
        $this->addSql('DROP TABLE dmp_settings');
        $this->addSql('ALTER TABLE dmp_administrative_data CHANGE project_name project_name VARCHAR(255) NOT NULL');
    }
}
