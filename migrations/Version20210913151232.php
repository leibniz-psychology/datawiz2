<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210913151232 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE dataset_meta_data DROP FOREIGN KEY FK_AAAE2F92B9CB5A8F');
        $this->addSql('CREATE TABLE dataset (id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', experiment_id BINARY(16) DEFAULT NULL COMMENT \'(DC2Type:uuid)\', at_upload_nameable VARCHAR(255) NOT NULL, storage_name VARCHAR(256) NOT NULL, INDEX IDX_B7A041D0FF444C8 (experiment_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE dataset_variables (id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', dataset_id BINARY(16) DEFAULT NULL COMMENT \'(DC2Type:uuid)\', var_id INT NOT NULL, name VARCHAR(250) NOT NULL, label VARCHAR(500) DEFAULT NULL, item_text LONGTEXT DEFAULT NULL, val_label LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:array)\', missings LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:array)\', measure VARCHAR(250) DEFAULT NULL, INDEX IDX_1C30D2A3D47C2D1B (dataset_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE dataset ADD CONSTRAINT FK_B7A041D0FF444C8 FOREIGN KEY (experiment_id) REFERENCES experiment (id)');
        $this->addSql('ALTER TABLE dataset_variables ADD CONSTRAINT FK_1C30D2A3D47C2D1B FOREIGN KEY (dataset_id) REFERENCES dataset (id)');
        $this->addSql('DROP TABLE original_dataset');
        $this->addSql('DROP INDEX UNIQ_AAAE2F92B9CB5A8F ON dataset_meta_data');
        $this->addSql('ALTER TABLE dataset_meta_data CHANGE original_dataset_id dataset_id BINARY(16) DEFAULT NULL COMMENT \'(DC2Type:uuid)\'');
        $this->addSql('ALTER TABLE dataset_meta_data ADD CONSTRAINT FK_AAAE2F92D47C2D1B FOREIGN KEY (dataset_id) REFERENCES dataset (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_AAAE2F92D47C2D1B ON dataset_meta_data (dataset_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE dataset_meta_data DROP FOREIGN KEY FK_AAAE2F92D47C2D1B');
        $this->addSql('ALTER TABLE dataset_variables DROP FOREIGN KEY FK_1C30D2A3D47C2D1B');
        $this->addSql('CREATE TABLE original_dataset (id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', experiment_id BINARY(16) DEFAULT NULL COMMENT \'(DC2Type:uuid)\', at_upload_nameable VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, storage_name VARCHAR(256) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, INDEX IDX_3120EF27FF444C8 (experiment_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE original_dataset ADD CONSTRAINT FK_3120EF27FF444C8 FOREIGN KEY (experiment_id) REFERENCES experiment (id)');
        $this->addSql('DROP TABLE dataset');
        $this->addSql('DROP TABLE dataset_variables');
        $this->addSql('DROP INDEX UNIQ_AAAE2F92D47C2D1B ON dataset_meta_data');
        $this->addSql('ALTER TABLE dataset_meta_data CHANGE dataset_id original_dataset_id BINARY(16) DEFAULT NULL COMMENT \'(DC2Type:uuid)\'');
        $this->addSql('ALTER TABLE dataset_meta_data ADD CONSTRAINT FK_AAAE2F92B9CB5A8F FOREIGN KEY (original_dataset_id) REFERENCES original_dataset (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_AAAE2F92B9CB5A8F ON dataset_meta_data (original_dataset_id)');
    }
}
