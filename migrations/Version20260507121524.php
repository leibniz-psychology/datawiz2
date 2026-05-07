<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260507121524 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add ethics fields to experiment';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE experiment_ethics (ethical_review VARCHAR(255) DEFAULT NULL, informed_consent VARCHAR(255) DEFAULT NULL, personal_data VARCHAR(255) DEFAULT NULL, copyright VARCHAR(255) DEFAULT NULL, third_party_rights VARCHAR(255) DEFAULT NULL, id BINARY(16) NOT NULL, experiment_id BINARY(16) DEFAULT NULL, UNIQUE INDEX UNIQ_2C2B6599FF444C8 (experiment_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('ALTER TABLE experiment_ethics ADD CONSTRAINT FK_2C2B6599FF444C8 FOREIGN KEY (experiment_id) REFERENCES experiment (id)');
        $this->addSql(
            'INSERT INTO experiment_ethics (id, experiment_id)
             SELECT UUID(), id
             FROM experiment
             WHERE id NOT IN (SELECT DISTINCT experiment_id FROM experiment_ethics WHERE experiment_id IS NOT NULL)'
        );
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE experiment_ethics DROP FOREIGN KEY FK_2C2B6599FF444C8');
        $this->addSql('DROP TABLE experiment_ethics');
    }
}
