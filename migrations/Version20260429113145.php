<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260429113145 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'refactor experiment_method table';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE experiment_method ADD research_method VARCHAR(255) DEFAULT NULL, DROP research_design, CHANGE setting setting VARCHAR(255) DEFAULT NULL, CHANGE experimental_details experimental_details VARCHAR(255) DEFAULT NULL, CHANGE non_experimental_details non_experimental_details VARCHAR(255) DEFAULT NULL, CHANGE observational_type observational_type VARCHAR(255) DEFAULT NULL, CHANGE experimental_design experimental_design VARCHAR(255) DEFAULT NULL, CHANGE control_operations control_operations VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE experiment_method ADD research_design TEXT DEFAULT NULL, DROP research_method, CHANGE experimental_details experimental_details TEXT DEFAULT NULL, CHANGE non_experimental_details non_experimental_details TEXT DEFAULT NULL, CHANGE observational_type observational_type TEXT DEFAULT NULL, CHANGE setting setting TEXT DEFAULT NULL, CHANGE experimental_design experimental_design TEXT DEFAULT NULL, CHANGE control_operations control_operations TEXT DEFAULT NULL');
    }
}
