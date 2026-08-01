<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260731134045 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE project_material (original_name VARCHAR(256) NOT NULL, original_mimetype VARCHAR(256) NOT NULL, date_uploaded DATETIME NOT NULL, original_size INT NOT NULL, description LONGTEXT DEFAULT NULL, storage_name VARCHAR(256) NOT NULL, id BINARY(16) NOT NULL, project_id BINARY(16) DEFAULT NULL, INDEX IDX_41F0FE4E166D1F9C (project_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('ALTER TABLE project_material ADD CONSTRAINT FK_41F0FE4E166D1F9C FOREIGN KEY (project_id) REFERENCES project (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE project_material DROP FOREIGN KEY FK_41F0FE4E166D1F9C');
        $this->addSql('DROP TABLE project_material');
    }
}
