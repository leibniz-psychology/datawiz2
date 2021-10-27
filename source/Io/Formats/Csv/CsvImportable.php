<?php


namespace App\Io\Formats\Csv;


use League\Csv\Exception;
use League\Csv\Reader;
use League\Csv\Writer;
use League\Flysystem\FileNotFoundException;
use League\Flysystem\FilesystemInterface;
use Psr\Log\LoggerInterface;

class CsvImportable
{
    private FilesystemInterface $filesystem;
    private LoggerInterface $logger;

    /**
     * CsvImport constructor.
     * @param FilesystemInterface $assetsFilesystem
     * @param LoggerInterface $logger
     */
    public function __construct(FilesystemInterface $assetsFilesystem, LoggerInterface $logger)
    {
        $this->logger = $logger;
        $this->filesystem = $assetsFilesystem;
    }

    public function csvToArray(string $fileId, string $delimiter, string $escape, int $headerRows, int $resultSize = 0): ?array
    {
        $result = null;
        try {
            $fileContent = $this->filesystem->read($fileId);
            $csv = Reader::createFromString($fileContent);
            if (0 < $headerRows) {
                $csv->setHeaderOffset($headerRows - 1);
            }
            $csv->setDelimiter($delimiter == 't' ? "\t" : $delimiter);
            switch ($escape) {
                case "double":
                    $csv->setEscape("\"");
                    break;
                case "single":
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
                $count++;
            }
        } catch (FileNotFoundException $e) {
            $this->logger->error("CsvImportable::csvToArray FileNotFoundException thrown: {$e->getMessage()}");
        } catch (Exception $e) {
            $this->logger->error("CsvImportable::csvToArray CSV Reader Exception thrown: {$e->getMessage()}");
        }

        return $result;
    }
}