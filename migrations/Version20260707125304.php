<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260707125304 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE experiment_ethics ADD data_sharing_level VARCHAR(255) DEFAULT NULL, ADD data_sharing_infrastructure LONGTEXT DEFAULT NULL');
        $this->addSql('ALTER TABLE experiment_measure ADD collection_investigator_presence LONGTEXT DEFAULT NULL');
        $this->addSql('ALTER TABLE experiment_ethics DROP anonymization, DROP anonymization_description');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE experiment_ethics DROP data_sharing_level, DROP data_sharing_infrastructure');
        $this->addSql('ALTER TABLE experiment_measure DROP collection_investigator_presence');
        // $this->addSql('ALTER TABLE experiment_ethics ADD anonymization VARCHAR(255) DEFAULT NULL, ADD anonymization_description LONGTEXT DEFAULT NULL');
    }
}
