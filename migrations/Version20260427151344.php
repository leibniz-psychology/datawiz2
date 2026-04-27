<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260427151344 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Extend Basic Information MetaDataGroup';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE experiment_basic ADD title_translated VARCHAR(255) DEFAULT NULL, ADD study_id VARCHAR(255) DEFAULT NULL, ADD description_translated LONGTEXT DEFAULT NULL, ADD data_status VARCHAR(255) DEFAULT NULL, ADD data_status_other_description LONGTEXT DEFAULT NULL, ADD reuse_potential_of_data_subset LONGTEXT DEFAULT NULL, ADD study_relation VARCHAR(255) DEFAULT NULL, ADD study_relation_other_description LONGTEXT DEFAULT NULL, ADD used_softwares JSON DEFAULT NULL, ADD conflicts_of_interest JSON DEFAULT NULL, CHANGE description description LONGTEXT DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE experiment_basic DROP title_translated, DROP study_id, DROP description_translated, DROP data_status, DROP data_status_other_description, DROP reuse_potential_of_data_subset, DROP study_relation, DROP study_relation_other_description, DROP used_softwares, DROP conflicts_of_interest, CHANGE description description TEXT DEFAULT NULL');
    }
}
