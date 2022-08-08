<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210914113742 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE experiment_basic (id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', experiment_id BINARY(16) DEFAULT NULL COMMENT \'(DC2Type:uuid)\', creator TEXT DEFAULT NULL COMMENT \'(DC2Type:array)\', contact TEXT DEFAULT NULL COMMENT \'(DC2Type:array)\', title TINYTEXT DEFAULT NULL, description TEXT DEFAULT NULL, related_publications TEXT DEFAULT NULL COMMENT \'(DC2Type:array)\', UNIQUE INDEX UNIQ_380555C7FF444C8 (experiment_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE experiment_basic ADD CONSTRAINT FK_380555C7FF444C8 FOREIGN KEY (experiment_id) REFERENCES experiment (id)');
        $this->addSql('DROP TABLE basic_information_meta_data_group');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE basic_information_meta_data_group (id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', experiment_id BINARY(16) DEFAULT NULL COMMENT \'(DC2Type:uuid)\', creator TEXT CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci` COMMENT \'(DC2Type:array)\', contact TEXT CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci` COMMENT \'(DC2Type:array)\', title TINYTEXT CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, description TEXT CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, related_publications TEXT CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci` COMMENT \'(DC2Type:array)\', UNIQUE INDEX UNIQ_896C4F9FF444C8 (experiment_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE basic_information_meta_data_group ADD CONSTRAINT FK_896C4F9FF444C8 FOREIGN KEY (experiment_id) REFERENCES experiment (id)');
        $this->addSql('DROP TABLE experiment_basic');
    }
}
