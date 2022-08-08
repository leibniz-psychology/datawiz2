<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210923112434 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE experiment_basic_creators (id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', basic_id BINARY(16) DEFAULT NULL COMMENT \'(DC2Type:uuid)\', given_name TINYTEXT DEFAULT NULL, family_name TINYTEXT DEFAULT NULL, email TINYTEXT DEFAULT NULL, affiliation TEXT DEFAULT NULL, INDEX IDX_9AB88527732A1162 (basic_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE experiment_basic_creators ADD CONSTRAINT FK_9AB88527732A1162 FOREIGN KEY (basic_id) REFERENCES experiment_basic (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE experiment_basic_creators');
    }
}
