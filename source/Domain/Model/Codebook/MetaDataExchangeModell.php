<?php


namespace App\Domain\Model\Codebook;


use Symfony\Component\DependencyInjection\Variable;

class MetaDataExchangeModell implements \JsonSerializable
{
    private $variables;

    private function __construct()
    {
        $this->variables = [];
    }

    public function getVariables()
    {
        return $this->variables;
    }

    public function addVariable($addedVariable)
    {
        $this->variables[] = $addedVariable;
    }

    public function removeVariable($removedVariable)
    {
        return array_diff($this->variables, [$removedVariable]);
    }

    public static function createFrom(array $variables ): MetaDataExchangeModell
    {
        $exchangeModell = new MetaDataExchangeModell();

        foreach ($variables as $variable) {
            if ($variable instanceof VariableModell) {
                $exchangeModell->addVariable($variable);
            }
        }

        return $exchangeModell;
    }

    public static function createEmpty(): MetaDataExchangeModell
    {
        return new MetaDataExchangeModell();
    }


    public function jsonSerialize()
    {
        return get_object_vars($this);
    }
}