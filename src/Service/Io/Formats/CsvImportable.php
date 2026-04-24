<?php

namespace App\Service\Io\Formats;

use League\Csv\Exception;
use League\Csv\Reader;
use League\Flysystem\FilesystemException;
use League\Flysystem\FilesystemOperator;
use League\Flysystem\UnableToReadFile;
use Psr\Log\LoggerInterface;

readonly class CsvImportable
{
    public function __construct(
        private FilesystemOperator $datasetFilesystem,
        private LoggerInterface $logger
    ) {
    }

    public function csvToArray(string $fileId, string $delimiter, string $escape, int $headerRows, int $resultSize = 0): ?array
    {
        $result = null;
        try {
            $fileContent = $this->datasetFilesystem->read($fileId);
            $csv = Reader::createFromString($fileContent);
            if ($headerRows > 0) {
                $csv->setHeaderOffset($headerRows - 1);
            }
            $csv->setDelimiter($delimiter == 't' ? "\t" : $delimiter);
            switch ($escape) {
                case 'double':
                    $csv->setEscape('"');
                    break;
                case 'single':
                    $csv->setEscape("'");
                    break;
            }
            $result['header'] = $csv->getHeader();
            $records = $csv->getRecords();
            $count = 0;
            foreach ($records as $record) {
                if ($resultSize != 0 && $resultSize <= $count) {
                    break;
                }
                $result['records'][] = $record;
                ++$count;
            }
        } catch (UnableToReadFile $e) {
            $this->logger->error("CsvImportable::csvToArray Unable to read file: {$e->getMessage()}");
        } catch (Exception $e) {
            $this->logger->error("CsvImportable::csvToArray CSV Reader Exception thrown: {$e->getMessage()}");
        } catch (FilesystemException $e) {
            $this->logger->error("CsvImportable::csvToArray FilesystemException: {$e->getMessage()}");
        }

        return $result;
    }
}
