<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Exception;
use Doctrine\DBAL\Schema\Schema;
use Doctrine\DBAL\Types\ConversionException;
use Doctrine\DBAL\Types\JsonType;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230428165114 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Replace deprecated DC2Type:array with DC2Type:json';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE dataset_variables CHANGE val_label val_label LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:json)\', CHANGE missings missings LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:json)\'');
        $this->addSql('ALTER TABLE experiment_basic CHANGE related_publications related_publications LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:json)\'');
        $this->addSql('ALTER TABLE experiment_basic_creators CHANGE credit_roles credit_roles LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:json)\'');
        $this->addSql('ALTER TABLE experiment_measure CHANGE measures measures LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:json)\', CHANGE apparatus apparatus LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:json)\'');
        $this->addSql('ALTER TABLE experiment_sample CHANGE inclusion_criteria inclusion_criteria LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:json)\', CHANGE exclusion_criteria exclusion_criteria LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:json)\', CHANGE population population LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:json)\'');
        $this->convertColumnToJson('dataset_variables', 'val_label', 'id', 'dataset_id');
        $this->convertColumnToJson('dataset_variables', 'missings', 'id', 'dataset_id');
        $this->convertColumnToJson('experiment_basic', 'related_publications', 'id', 'experiment_id');
        $this->convertColumnToJson('experiment_basic_creators', 'credit_roles', 'id', 'basic_id');
        $this->convertColumnToJson('experiment_measure', 'measures', 'id', 'experiment_id');
        $this->convertColumnToJson('experiment_measure', 'apparatus', 'id', 'experiment_id');
        $this->convertColumnToJson('experiment_sample', 'inclusion_criteria', 'id', 'experiment_id');
        $this->convertColumnToJson('experiment_sample', 'exclusion_criteria', 'id', 'experiment_id');
        $this->convertColumnToJson('experiment_sample', 'population', 'id', 'experiment_id');
    }

    public function preDown(Schema $schema): void
    {
        $this->throwIrreversibleMigrationException();
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE dataset_variables CHANGE val_label val_label LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:array)\', CHANGE missings missings LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:array)\'');
        $this->addSql('ALTER TABLE experiment_basic_creators CHANGE credit_roles credit_roles LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:array)\'');
        $this->addSql('ALTER TABLE experiment_basic CHANGE related_publications related_publications TEXT DEFAULT NULL COMMENT \'(DC2Type:array)\'');
        $this->addSql('ALTER TABLE experiment_sample CHANGE inclusion_criteria inclusion_criteria TEXT DEFAULT NULL COMMENT \'(DC2Type:array)\', CHANGE exclusion_criteria exclusion_criteria TEXT DEFAULT NULL COMMENT \'(DC2Type:array)\', CHANGE population population TEXT DEFAULT NULL COMMENT \'(DC2Type:array)\'');
        $this->addSql('ALTER TABLE experiment_measure CHANGE measures measures TEXT DEFAULT NULL COMMENT \'(DC2Type:array)\', CHANGE apparatus apparatus TEXT DEFAULT NULL COMMENT \'(DC2Type:array)\'');
    }

    private function convertColumnToJson(string $tableName, string $columnName, string $id, string $subId): void
    {
        $queryBuilder = $this->connection->createQueryBuilder();
        $queryBuilder->select($id, $subId, $columnName)->from($tableName);
        try {
            $table = $queryBuilder->executeQuery()->fetchAllAssociative();
        } catch (Exception $e) {
            throw new \Error('Could not fetch table '.$tableName, $e->getCode(), $e);
        }
        if (count($table) === 0) { // should ArrayType no longer be supported, don't throw an error if a new instance of datawiz is created
            return;
        }
        foreach ($table as $row) {
            $array = $this->convertArrayToJson($row[$columnName]);
            $qb = $this->connection->createQueryBuilder();
            $qb->update($tableName, 'tab')
                ->set('tab.'.$columnName, ':array')
                ->setParameter('array', $array)
                ->andWhere($id.' = :id')
                ->andWhere($subId.' = :subId')
                ->setParameter('id', $row[$id])
                ->setParameter('subId', $row[$subId]);
            $this->addSql($qb->getSQL(), $qb->getParameters());
        }
    }

    private function convertArrayToJson(string $array): null|string
    {
        $platform = $this->platform;

        if (class_exists(\Doctrine\DBAL\Types\ArrayType::class)) {
            $arrayType = new \Doctrine\DBAL\Types\ArrayType();
            try {
                $array = $arrayType->convertToPHPValue($array, $platform);
            } catch (ConversionException $e) {
                throw new \Error('Could not convert Doctrine\DBAL\Types\ArrayType to PHP value: '.$array, $e->getCode(), $e);
            }
        } else {
            $array = unserialize($array);
        }

        $jsonType = new JsonType();
        try {
            $array = $jsonType->convertToDatabaseValue($array, $platform);
        } catch (ConversionException $e) {
            throw new \Error('Could not convert PHP array to Doctrine\DBAL\Types\JsonType', $e->getCode(), $e);
        }
        return $array;
    }
}
