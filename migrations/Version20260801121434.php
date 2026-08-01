<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260801121434 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE project_data_management_plan (project_id BINARY(16) NOT NULL, data_management_plan_id BINARY(16) NOT NULL, INDEX IDX_1AE056D1166D1F9C (project_id), INDEX IDX_1AE056D1B9AD4E0E (data_management_plan_id), PRIMARY KEY (project_id, data_management_plan_id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('ALTER TABLE project_data_management_plan ADD CONSTRAINT FK_1AE056D1166D1F9C FOREIGN KEY (project_id) REFERENCES project (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE project_data_management_plan ADD CONSTRAINT FK_1AE056D1B9AD4E0E FOREIGN KEY (data_management_plan_id) REFERENCES data_management_plan (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE project_data_management_plan DROP FOREIGN KEY FK_1AE056D1166D1F9C');
        $this->addSql('ALTER TABLE project_data_management_plan DROP FOREIGN KEY FK_1AE056D1B9AD4E0E');
        $this->addSql('DROP TABLE project_data_management_plan');
    }
}
