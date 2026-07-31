<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260731131018 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE project (date_created DATETIME NOT NULL, id BINARY(16) NOT NULL, owner_id BINARY(16) DEFAULT NULL, INDEX IDX_2FB3D0EE7E3C61F9 (owner_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE project_administrative_data (project_title VARCHAR(255) DEFAULT NULL, project_id VARCHAR(255) DEFAULT NULL, project_objectives LONGTEXT DEFAULT NULL, funding VARCHAR(255) DEFAULT NULL, grant_number VARCHAR(255) DEFAULT NULL, id BINARY(16) NOT NULL, project_entity_id BINARY(16) DEFAULT NULL, UNIQUE INDEX UNIQ_83269DBE9019388A (project_entity_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE project_settings (short_name VARCHAR(255) DEFAULT NULL, id BINARY(16) NOT NULL, project_id BINARY(16) DEFAULT NULL, UNIQUE INDEX UNIQ_D80B2B1E166D1F9C (project_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('ALTER TABLE project ADD CONSTRAINT FK_2FB3D0EE7E3C61F9 FOREIGN KEY (owner_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE project_administrative_data ADD CONSTRAINT FK_83269DBE9019388A FOREIGN KEY (project_entity_id) REFERENCES project (id)');
        $this->addSql('ALTER TABLE project_settings ADD CONSTRAINT FK_D80B2B1E166D1F9C FOREIGN KEY (project_id) REFERENCES project (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE project DROP FOREIGN KEY FK_2FB3D0EE7E3C61F9');
        $this->addSql('ALTER TABLE project_administrative_data DROP FOREIGN KEY FK_83269DBE9019388A');
        $this->addSql('ALTER TABLE project_settings DROP FOREIGN KEY FK_D80B2B1E166D1F9C');
        $this->addSql('DROP TABLE project');
        $this->addSql('DROP TABLE project_administrative_data');
        $this->addSql('DROP TABLE project_settings');
    }
}
