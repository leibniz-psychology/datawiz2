<?php

namespace App\Service\Io\Formats;

use App\Entity\FileManagement\Dataset;
use App\Service\Api\SpssApiClient;
use Psr\Log\LoggerInterface;

class SavImportable
{
    public function __construct(private readonly SpssApiClient $spssApiClient, private readonly LoggerInterface $logger)
    {
    }

    public function savToArray(Dataset $dataset): array
    {
        $this->logger->debug("SavImportable::savToArray:Enter with Dataset: {$dataset->getId()}");
        $data = null;
        $sav = $this->spssApiClient->savToArray($dataset);
        if ($sav && key_exists('variables', $sav)) {
            $count = 1;
            foreach ($sav['variables'] as $var) {
                $cv['id'] = $count++;
                $cv['name'] = key_exists('name', $var) ? $var['name'] : '';
                $cv['label'] = key_exists('label', $var) ? $var['label'] : '';
                $cv['itemText'] = null;
                $cv['values'] = null;
                if (key_exists('values', $var) && is_iterable($var['values'])) {
                    foreach ($var['values'] as $val) {
                        if (is_iterable($val)) {
                            $cv['values'][] = $this->_createValueLabelArray($val);
                        }
                    }
                }
                $cv['missings'] = $this->_createMissings($var['missingFormat'], $var['missingVal1'], $var['missingVal2'], $var['missingVal3']);
                $codebook[] = $cv;
            }
            $data['codebook'] = $codebook ?? null;
        }
        if ($sav && key_exists('dataMatrix', $sav)) {
            $data['records'] = $sav['dataMatrix'];
        }
        $this->logger->debug('SavImportable::savToArray:Leave with result size: '.sizeof($data ?: []));

        return $data;
    }

    private function _createMissings(?string $type, ?string $val1, ?string $val2, ?string $val3): ?array
    {
        $this->logger->debug("SavImportable::_createMissings:Enter with Type: {$type}; Val1: {$val1}; Val2: {$val2}; Val3: {$val3};");
        $missings = null;
        if ($type) {
            switch ($type) {
                case 'SPSS_ONE_MISSVAL':
                case 'SPSS_TWO_MISSVAL':
                case 'SPSS_THREE_MISSVAL':
                    if ($val1) {
                        $missings[] = $this->_createValueLabelArray(['value' => $val1]);
                    }
                    if ($val2) {
                        $missings[] = $this->_createValueLabelArray(['value' => $val2]);
                    }
                    if ($val3) {
                        $missings[] = $this->_createValueLabelArray(['value' => $val3]);
                    }
                    break;
                case 'SPSS_MISS_RANGE':
                    if ($val1 && $val2) {
                        $missings[] = $this->_createValueLabelArray(['value' => $val1.' - '.$val2]);
                    }
                    break;
                case 'SPSS_MISS_RANGEANDVAL':
                    if ($val1 && $val2 && $val3) {
                        $missings[] = $this->_createValueLabelArray(['value' => $val1.' - '.$val2]);
                        $missings[] = $this->_createValueLabelArray(['value' => $val3]);
                    }
                    break;
            }
        }
        $this->logger->debug('SavImportable::_createMissings:Enter with result size: '.sizeof($missings ?: []));

        return $missings;
    }

    private function _createValueLabelArray(array $val): array
    {
        $this->logger->debug('SavImportable::_createValueLabelArray:Enter with array size: '.sizeof($val ?: []));

        return [
            'name' => key_exists('value', $val) ? $val['value'] : '',
            'label' => key_exists('label', $val) ? $val['label'] : '',
        ];
    }
}
