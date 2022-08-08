<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210914113305 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE dataset_meta_data');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE dataset_meta_data (id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', dataset_id BINARY(16) DEFAULT NULL COMMENT \'(DC2Type:uuid)\', metadata LONGTEXT CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci` COMMENT \'(DC2Type:json)\', UNIQUE INDEX UNIQ_AAAE2F92D47C2D1B (dataset_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE dataset_meta_data ADD CONSTRAINT FK_AAAE2F92D47C2D1B FOREIGN KEY (dataset_id) REFERENCES dataset (id)');
    }
}
