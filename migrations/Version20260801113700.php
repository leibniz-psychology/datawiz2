<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260801113700 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE project_experiment (project_id BINARY(16) NOT NULL, experiment_id BINARY(16) NOT NULL, INDEX IDX_BC92380166D1F9C (project_id), INDEX IDX_BC92380FF444C8 (experiment_id), PRIMARY KEY (project_id, experiment_id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('ALTER TABLE project_experiment ADD CONSTRAINT FK_BC92380166D1F9C FOREIGN KEY (project_id) REFERENCES project (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE project_experiment ADD CONSTRAINT FK_BC92380FF444C8 FOREIGN KEY (experiment_id) REFERENCES experiment (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE project_experiment DROP FOREIGN KEY FK_BC92380166D1F9C');
        $this->addSql('ALTER TABLE project_experiment DROP FOREIGN KEY FK_BC92380FF444C8');
        $this->addSql('DROP TABLE project_experiment');
    }
}
