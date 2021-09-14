<?php

declare(strict_types=1);

namespace App\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210914120505 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE settings DROP FOREIGN KEY FK_5A8F8A227E3C61F9');
        $this->addSql('DROP INDEX uniq_5a8f8a227e3c61f9 ON settings');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_E545A0C57E3C61F9 ON settings (owner_id)');
        $this->addSql('ALTER TABLE settings ADD CONSTRAINT FK_5A8F8A227E3C61F9 FOREIGN KEY (owner_id) REFERENCES user (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE settings DROP FOREIGN KEY FK_E545A0C57E3C61F9');
        $this->addSql('DROP INDEX uniq_e545a0c57e3c61f9 ON settings');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_5A8F8A227E3C61F9 ON settings (owner_id)');
        $this->addSql('ALTER TABLE settings ADD CONSTRAINT FK_E545A0C57E3C61F9 FOREIGN KEY (owner_id) REFERENCES user (id)');
    }
}
