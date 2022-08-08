<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210920110723 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE material ADD original_name VARCHAR(256) NOT NULL, ADD original_mimetype VARCHAR(256) NOT NULL, ADD date_uploaded DATETIME NOT NULL, ADD original_size INT NOT NULL, ADD description LONGTEXT DEFAULT NULL, DROP at_upload_nameable, DROP upload_date, DROP file_size, DROP file_type, DROP file_description, CHANGE storage_name storage_name VARCHAR(256) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE material ADD at_upload_nameable VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, ADD upload_date DATETIME DEFAULT NULL, ADD file_size VARCHAR(256) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, ADD file_type VARCHAR(12) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, ADD file_description VARCHAR(256) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, DROP original_name, DROP original_mimetype, DROP date_uploaded, DROP original_size, DROP description, CHANGE storage_name storage_name VARCHAR(256) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`');
    }
}
