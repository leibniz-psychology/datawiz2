<?php

declare(strict_types=1);

namespace App\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210914120712 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE material (id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', experiment_id BINARY(16) DEFAULT NULL COMMENT \'(DC2Type:uuid)\', at_upload_nameable VARCHAR(255) NOT NULL, storage_name VARCHAR(256) DEFAULT NULL, upload_date DATETIME DEFAULT NULL, file_size VARCHAR(256) DEFAULT NULL, file_type VARCHAR(12) DEFAULT NULL, file_description VARCHAR(256) DEFAULT NULL, INDEX IDX_7CBE7595FF444C8 (experiment_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE material ADD CONSTRAINT FK_7CBE7595FF444C8 FOREIGN KEY (experiment_id) REFERENCES experiment (id)');
        $this->addSql('DROP TABLE additional_material');
        $this->addSql('DROP TABLE converted_dataset');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE additional_material (id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', experiment_id BINARY(16) DEFAULT NULL COMMENT \'(DC2Type:uuid)\', at_upload_nameable VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, storage_name VARCHAR(256) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, upload_date DATETIME DEFAULT NULL, file_size VARCHAR(256) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, file_type VARCHAR(12) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, file_description VARCHAR(256) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, INDEX IDX_C66FC943FF444C8 (experiment_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE converted_dataset (id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE additional_material ADD CONSTRAINT FK_C66FC943FF444C8 FOREIGN KEY (experiment_id) REFERENCES experiment (id)');
        $this->addSql('DROP TABLE material');
    }
}
