<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260428125812 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'In experiment_theory, add new theories column and change objective and hypothesis to arrays';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE experiment_theory ADD theories JSON DEFAULT NULL');
        // Add temporary JSON columns
        $this->addSql('ALTER TABLE experiment_theory ADD objective_new JSON DEFAULT NULL');
        $this->addSql('ALTER TABLE experiment_theory ADD hypothesis_new JSON DEFAULT NULL');

        // Transform data: wrap non-null values in JSON arrays
        $this->addSql('UPDATE experiment_theory SET objective_new = JSON_ARRAY(objective) WHERE objective IS NOT NULL');
        $this->addSql('UPDATE experiment_theory SET hypothesis_new = JSON_ARRAY(hypothesis) WHERE hypothesis IS NOT NULL');

        // Drop old TEXT columns and rename new JSON columns
        $this->addSql('ALTER TABLE experiment_theory DROP COLUMN objective');
        $this->addSql('ALTER TABLE experiment_theory DROP COLUMN hypothesis');
        $this->addSql('ALTER TABLE experiment_theory RENAME COLUMN objective_new TO objectives');
        $this->addSql('ALTER TABLE experiment_theory RENAME COLUMN hypothesis_new TO hypotheses');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE experiment_theory DROP theories');
        // Add temporary TEXT columns
        $this->addSql('ALTER TABLE experiment_theory ADD objective_old LONGTEXT DEFAULT NULL');
        $this->addSql('ALTER TABLE experiment_theory ADD hypothesis_old LONGTEXT DEFAULT NULL');

        // Restore original data: extract first element from arrays
        $this->addSql('UPDATE experiment_theory SET objective_old = JSON_UNQUOTE(JSON_EXTRACT(objectives, "$[0]")) WHERE objectives IS NOT NULL');
        $this->addSql('UPDATE experiment_theory SET hypothesis_old = JSON_UNQUOTE(JSON_EXTRACT(hypotheses, "$[0]")) WHERE hypotheses IS NOT NULL');

        // Drop JSON columns and rename old TEXT columns back
        $this->addSql('ALTER TABLE experiment_theory DROP COLUMN objectives');
        $this->addSql('ALTER TABLE experiment_theory DROP COLUMN hypotheses');
        $this->addSql('ALTER TABLE experiment_theory RENAME COLUMN objective_old TO objective');
        $this->addSql('ALTER TABLE experiment_theory RENAME COLUMN hypothesis_old TO hypothesis');
    }
}
