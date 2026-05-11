<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260511092034 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Change credit_roles to responsibilities in experiment_basic_creators table';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE experiment_basic_creators ADD responsibilities LONGTEXT DEFAULT NULL, ADD responsibilities_other_description VARCHAR(255) DEFAULT NULL, DROP credit_roles');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE experiment_basic_creators ADD credit_roles JSON DEFAULT NULL, DROP responsibilities, DROP responsibilities_other_description');
    }
}
